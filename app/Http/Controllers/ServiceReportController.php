<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\ServiceReport;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;

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

        return view('processes.sales.service-report.create', [
            'shippingAddress' => $shippingAddress,
            'orderConfirmations' => $orderConfirmations
        ]);
    }
}
