<?php

namespace App\Http\Controllers;

use App\Models\ServiceReport;
use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function details(string $reportId) {
        return view('processes.sales.service-report.details', [
            'report' => ServiceReport::where('id', $reportId)->firstOrFail()
        ]);
    }
}
