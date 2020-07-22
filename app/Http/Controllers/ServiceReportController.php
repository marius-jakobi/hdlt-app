<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\ServiceReport;
use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function details(string $reportId) {
        return view('processes.sales.service-report.details', [
            'report' => ServiceReport::where('id', $reportId)->firstOrFail()
        ]);
    }

    public function create(string $documentNumber) {
        $orderConfirmation = OrderConfirmation::where('document_number', $documentNumber)->firstOrFail();
        $shippingAddresses = $orderConfirmation->salesProcess->customer->shippingAddresses;

        return view('processes.sales.service-report.create', [
            'orderConfirmation' => $orderConfirmation,
            'shippingAddresses' => $shippingAddresses
        ]);
    }
}
