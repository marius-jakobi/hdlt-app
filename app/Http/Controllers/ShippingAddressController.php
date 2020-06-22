<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ShippingAddress;
use App\ShippingAddressUploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingAddressController extends Controller
{
    /**
     * View shipping address details
     * 
     * @param int $customerId Customer ID
     * @param int $addressId Address ID
     * @return View
     */
    public function details(int $customerId, int $addressId) {
        $shippingAddress = ShippingAddress::findOrFail($addressId);

        $this->authorize('view', $shippingAddress);

        return view('customer.addresses.shipping.details', ['shippingAddress' => $shippingAddress]);
    }

    /**
     * Update a address
     * 
     * @param Request $request
     * @param int $customerId Customer ID
     * @param int $addressId Address ID
     * @return RedirectResponse
     */
    public function update(Request $request, int $customerId, int $addressId) {
        $back = route('customer.addresses.shipping.details', [
            'customerId' => $customerId,
            'addressId' => $addressId
        ]);

        $address = ShippingAddress::findOrFail($addressId);

        $this->authorize('update', $address);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'street' => 'required',
            'zip' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($back)
                ->withErrors($validator);
        }

        $address->name = $request->input('name');
        $address->street = $request->input('street');
        $address->zip = $request->input('zip');
        $address->city = $request->input('city');
        $address->save();

        return redirect($back)
            ->with('success', 'Die Lieferadresse wurde aktualisiert');
    }

    /**
     * Show create form
     * 
     * @param string $customerId The Customer ID to which the address should be added
     * @return View
     */
    public function create($customerId) {
        $customer = Customer::findOrFail($customerId);

        $this->authorize('create', ShippingAddress::class);
        
        return view ('customer.addresses.shipping.create', ['customer' => $customer]);
    }

    /**
     * Store address in database
     * 
     * @param Request $request
     * @param string $customerId The Customer ID to which the address should be added
     */
    public function store(Request $request, string $customerId) {
        $back = route('customer.addresses.shipping.create', ['customerId' => $customerId]);

        $customer = Customer::findOrFail($customerId);

        $this->authorize('create', ShippingAddress::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'street' => 'required',
            'zip' => 'required',
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($back)
                ->withInput()
                ->withErrors($validator);
        }

        $address = new ShippingAddress([
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'zip' => $request->input('zip'),
            'city' => $request->input('city')
        ]);

        $customer->shippingAddresses()->save($address);

        $address->save();

        return redirect(route('customer.details', ['customerId' => $customerId]))
            ->with('success', 'Die Lieferadresse wurde angelegt');
    }
}
