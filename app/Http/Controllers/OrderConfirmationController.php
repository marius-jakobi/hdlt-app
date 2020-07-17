<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use App\Models\SalesProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderConfirmationController extends Controller
{
    public function details(string $documentNumber) {
        return view('processes.sales.order-confirmation.details', [
            'orderConfirmation' => OrderConfirmation::where('document_number', $documentNumber)->firstOrFail()
            ]);
    }

    public function create(string $processNumber) {
        $salesProcess = SalesProcess::where('process_number', $processNumber)->firstOrFail();

        return view('processes.sales.order-confirmation.create', ['salesProcess' => $salesProcess]);
    }

    public function store(Request $request, string $processNumber) {
        $validator = Validator::make($request->input(), [
            'document_number' => 'required|unique:order_confirmations|size:10',
            'po_number' => 'max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $salesProcess = DB::table('process_sales')->where('process_number', '=', $processNumber)->first();

        if (!$salesProcess) {
            return redirect()->back()
                ->with('error', 'Der Verkaufsvorgang existiert nicht.');
        }

        $orderConfirmation = new OrderConfirmation([
            'document_number' => $request->input('document_number'),
            'sales_process_id' => $salesProcess->id,
            'po_number' => $request->input('po_number')
        ]);

        $orderConfirmation->save();

        return redirect(route('process.sales.order-confirmation.details', ['documentNumber' => $request->input('document_number')]))
            ->with('success', 'Die Auftragsbestätigung wurde angelegt');
    }
}
