<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service\ServiceOffer;
use Illuminate\Http\Request;

class ServiceOfferController extends Controller
{
    public function create(string $customerId) {
        $customer = Customer::where('id', $customerId)->firstOrFail();
        $shippingAddresses = $customer->shippingAddresses();
        $offer = new ServiceOffer();

        return view('offer.service.create', [
            'customer' => $customer,
            'shippingAddresses' => $shippingAddresses
        ]);
    }

    public function store(Request $request) {
        dd($request);
    }
}
