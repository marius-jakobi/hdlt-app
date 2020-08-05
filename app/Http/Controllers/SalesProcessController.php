<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\SalesProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesProcessController extends Controller
{
    public function details(string $processNumber) {
        $process = SalesProcess::where('process_number', $processNumber)->firstOrFail();
        $orderConfirmations = OrderConfirmation::where('sales_process_id', '=', $process->id)->orderBy('created_at', 'desc')->paginate(8);

        return view('processes.sales.details', [
            'process' => $process,
            'orderConfirmations' => $orderConfirmations
            ]);
    }

    public function create(string $custId) {
        return view('processes.sales.create', [
            'customer' => DB::table('customers')->where('cust_id', '=', $custId)->first()
            ]);
    }

    public function store(Request $request, string $custId) {
        $rules = [
            'process_number' => 'required|size:6|unique:process_sales'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = DB::table('customers')->where('cust_id', '=', $custId)->first();

        if (!$customer) {
            return redirect()->back()
                ->with('error', 'Dieser Kunde existiert nicht.');
        }

        $salesProcess = new SalesProcess([
            'process_number' => $request->input('process_number'),
            'customer_id' => $customer->id
        ]);
        
        $salesProcess->save();

        return redirect(route('process.sales.details', ['processNumber' => $request->input('process_number')]))
            ->with('success', 'Der Vorgang wurde angelegt.');
    }
}
