<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\SalesProcess;
use App\Models\ServiceReport;
use App\Models\ShippingAddress;
use App\Models\StationComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        foreach (StationComponent::types() as $key => $value) {
            $components[$key] = StationComponent::getComponentClassname($key)::all();
        }

        return view('processes.sales.service-report.create', [
            'shippingAddress' => $shippingAddress,
            'orderConfirmations' => $orderConfirmations,
            'components' => $components,
            'scopes' => DB::table('service_scopes')->orderBy('description')->get()
        ]);
    }

    public function store(Request $request, string $shippingAddressId) {
        $input = $request->input();

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

        if (!$hasOrderConfirmation) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['document_number' => 'Diese Auftragsbestätigung gehört nicht zu diesem Kunden.']);
        }

        print('<pre>');
        var_dump($input);

        
    }
}
