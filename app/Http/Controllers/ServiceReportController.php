<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
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
}
