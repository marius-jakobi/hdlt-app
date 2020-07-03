<?php

namespace App\Http\Controllers;

use App\Models\OrderConfirmation;
use Illuminate\Http\Request;

class OrderConfirmationController extends Controller
{
    public function details(int $processNumber, string $documentNumber) {
        return view('processes.sales.order-confirmation.details', [
            'orderConfirmation' => OrderConfirmation::where('document_number', $documentNumber)->firstOrFail()
            ]);
    }
}
