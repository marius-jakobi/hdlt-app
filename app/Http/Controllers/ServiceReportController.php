<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\SalesProcess;
use App\Models\ServiceReport;
use App\Models\ShippingAddress;
use App\Models\StationComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceReportController extends Controller
{
    public function details(string $reportId) {
        return view('processes.sales.service-report.details', [
            'report' => ServiceReport::where('id', $reportId)->firstOrFail()
        ]);
    }

    public function create(string $shippingAddressId) {
        $shippingAddress = ShippingAddress::where('id', $shippingAddressId)->firstOrFail();
        $orderConfirmations = [];

        foreach($shippingAddress->customer->salesProcesses as $process) {
            foreach($process->orderConfirmations as $orderConfirmation) {
                $orderConfirmations[] = $orderConfirmation;
            }
        }

        $components = [];

        foreach (array_keys(StationComponent::types()) as $key) {
            $components[$key] = StationComponent::getComponentClassname($key)::where('shipping_address_id', $shippingAddressId)->get();
        }

        return view('processes.sales.service-report.create', [
            'shippingAddress' => $shippingAddress,
            'orderConfirmations' => $orderConfirmations,
            'components' => $components,
            'technicians' => DB::table('technicians')->where('is_active', true)->orderBy('name_last')->get(),
            'scopes' => DB::table('service_scopes')->orderBy('description')->get(),
            'testRuns' => ServiceReport::testRuns()
        ]);
    }

    public function store(Request $request, string $shippingAddressId) {
        $input = $request->input();

        // Basic rules
        $rules = [
            'intent' => 'required|between:4,128',
            'additional_work_required' => 'nullable|max:255',
            'test_run' => 'required|numeric|between:0,' . (count(ServiceReport::testRuns()) - 1),
            'components.compressors.*.hours_running' => 'nullable|numeric',
            'components.compressors.*.hours_loaded' => 'nullable|numeric',
            'components.compressors.*' => [
                function ($attribute, $value, $fail) {
                    if ($value['hours_loaded'] > $value['hours_running']) {
                        $fail('Die Betriebsstunden können nicht kleiner als die Laststunden sein.');
                    }
                }
            ]
        ];

        // related validation messages
        $messages = [
            'components.compressors.*.hours_running.numeric' => 'Die Betriebsstunden müssen eine Zahl sein.',
            'components.compressors.*.hours_loaded.numeric' => 'Die Laststunden müssen eine Zahl sein.',
            'test_run.*' => 'Dieser Wert für Probelauf ist ungültig.'
        ];

        // Dynamically add validation rules and messages for components
        foreach (array_keys($input['components']) as $type) {
            $rules["components.$type.*.scope_id"] =  'required|exists:service_scopes,id';
            $messages["components.$type.*.scope_id.required"] = 'Es muss ein Umfang angegeben werden.';
            $messages["components.$type.*.scope_id.exists"] = 'Dieser Umfang ist ungültig.';
        };

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        // Unset technicians that did not work on this service report
        foreach ($input['technicians'] as $technician_id => $technicianData) {
            if ((!$technicianData['time_start'] || intval($technicianData['time_start']) <= 0) &&
                 !$technicianData['time_end']   || intval($technicianData['time_end']    <= 0)) {
                unset($input['technicians'][$technician_id]);
            }
        }

        // Return with error if no technician is given
        if (count($input['technicians']) <= 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['technician.required' => 'Es muss für mindestens einen Mitarbeiter die Arbeitszeit eingegeben werden.']);
        }

        // Get order confirmation
        $orderConfirmation = OrderConfirmation::where('document_number', $input['document_number'])->first();

        if (!$orderConfirmation) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['document_number' => 'Diese Auftragsbestätigung existiert nicht.']);
        }

        // Get shipping address
        $shippingAddress = ShippingAddress::findOrFail($shippingAddressId);
        // Get sales processes for shipping address's customer
        $salesProcesses = SalesProcess::where('customer_id', $shippingAddress->customer->id)->get();

        // check if order confirmation belongs to any sales process of the parent customer
        $hasOrderConfirmation = false;

        foreach($salesProcesses as $salesProcess) {
            foreach($salesProcess->orderConfirmations as $oc) {
                if ($oc->document_number == $input['document_number']) {
                    $hasOrderConfirmation = true;
                }
            }
        }

        // Order confirmation does NOT belong to any customer process
        if (!$hasOrderConfirmation) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['document_number' => 'Diese Auftragsbestätigung gehört nicht zu diesem Kunden.']);
        }

        // Create new service report
        $serviceReport = new ServiceReport([
            'order_confirmation_id' => $orderConfirmation->id,
            'shipping_address_id' => $shippingAddressId,
            'intent' => $input['intent'],
            'text' => $input['text'],
            'test_run' => $input['test_run'],
            'additional_work_required' => $input['additional_work_required'],
        ]);

        // Save service report to give it a UID
        $serviceReport->save();

        // Attach technicians to report
        foreach($input['technicians'] as $technician_id => $technicianData) {
            // If a technician has a work time add it to the relationship
            if (intval($technicianData['time_end'] - $technicianData['time_start']) > 0) {
                DB::table('service_report_technicians')->insert([
                    'service_report_id' => $serviceReport->id,
                    'technician_id' => $technician_id,
                    'time_start' => $technicianData['time_start'],
                    'time_end' => $technicianData['time_end'],
                    'work_date' => $technicianData['work_date'],
                ]);
            }
        }

        /**
         * Add components to report
         * $groupKey: The key of the component group like 'compressors' or 'filters'
         * $componentGroup: Array of components in a component group
         */
        foreach ($input['components'] as $groupKey => $componentGroup) {
            /**
             * Iterate through component group
             * $componentId The array key contains the ID of a component
             * $componentData The item value contains the service data like scope and hours of the component
             */
            foreach ($componentGroup as $componentId => $componentData) {
                // Add basic data that is shared across all component types
                $row = [
                    'component_id' => $componentId,
                    'service_report_id' => $serviceReport->id,
                    'scope_id' => $componentData['scope_id']
                ];

                // If component is a compressor, add hours to row
                if ($groupKey === 'compressors') {
                    $row['hours_running'] = $componentData['hours_running'];
                    $row['hours_loaded'] = $componentData['hours_loaded'];
                }

                // Insert row with a components service data into database tables
                DB::table($groupKey . '_service_reports')->insert($row);

                // Update next service date
                if (isset($componentData['next_service'])) {
                    DB::table($groupKey)
                        ->where('id', '=', $componentId)
                        ->update(['next_service' => $componentData['next_service'] . '-01']);
                }
            }
        }

        return redirect()->route('process.sales.service-report.details', ['reportId' => $serviceReport->id])
            ->with('success', 'Der Service-Bericht wurde angelegt.');
    }
}
