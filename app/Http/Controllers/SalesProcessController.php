<?php

namespace App\Http\Controllers;

use App\Models\ProcessSales;
use Illuminate\Http\Request;

class SalesProcessController extends Controller
{
    public function details(int $processNumber) {
        return view('processes.sales.details', [
            'process' => ProcessSales::where('process_number', $processNumber)->firstOrFail()
            ]);
    }
}
