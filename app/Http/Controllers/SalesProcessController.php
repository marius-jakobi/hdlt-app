<?php

namespace App\Http\Controllers;

use App\Models\SalesProcess;
use Illuminate\Http\Request;

class SalesProcessController extends Controller
{
    public function details(int $processNumber) {
        return view('processes.sales.details', [
            'process' => SalesProcess::where('process_number', $processNumber)->firstOrFail()
            ]);
    }
}
