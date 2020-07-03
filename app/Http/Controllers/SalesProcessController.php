<?php

namespace App\Http\Controllers;

use App\Models\ProcessSales;
use Illuminate\Http\Request;

class SalesProcessController extends Controller
{
    public function details(int $process_number) {
        return view('processes.sales.details', [
            'process' => ProcessSales::where('process_number', $process_number)->firstOrFail()
            ]);
    }
}
