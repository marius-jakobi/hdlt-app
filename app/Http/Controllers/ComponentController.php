<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use App\StationComponent;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * Show creation form
     * 
     * @param int $customerId ID of the customer
     * @param int $addressId ID of the shipping address
     * @param string $type Type of component
     * @return View
     */
    public function create($customerId, $addressId, $type) {
        $validType = false;
        foreach (StationComponent::types() as $key => $value) {
            if ($type === $key) {
                $validType = true;
            }
        }

        if (!$validType) {
            return abort(404);
        }

        return view('component.create', ['shippingAddress' => ShippingAddress::findOrFail($addressId)]);
    }
}
