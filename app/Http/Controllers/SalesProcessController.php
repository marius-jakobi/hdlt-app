<?php

namespace App\Http\Controllers;

use App\Models\SalesProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesProcessController extends Controller
{
    public function details(int $processNumber) {
        return view('processes.sales.details', [
            'process' => SalesProcess::where('process_number', $processNumber)->firstOrFail()
            ]);
    }

    public function create(string $custId) {
        return view('processes.sales.create', [
            'customer' => DB::table('customers')->where('cust_id', '=', $custId)->first()
            ]);
    }

    public function store(Request $request, string $custId) {
        $rules = [
            'process_number' => 'required|size:6'
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

        DB::table('process_sales')->insert([
            'process_number' => $request->input('process_number'),
            'customer_id' => $customer->id
        ]);

        return redirect(route('process.sales.details', ['processNumber' => $request->input('process_number')]))
            ->with('success', 'Der Vorgang wurde angelegt.');
    }
}
