<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceReport;
use App\Models\ShippingAddress;
use App\Models\ShippingAddressUploadFile;
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
        $serviceReports = ServiceReport::where('shipping_address_id', $addressId)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->authorize('view', $shippingAddress);

        return view('customer.addresses.shipping.details', [
            'shippingAddress' => $shippingAddress,
            'serviceReports' => $serviceReports,
        ]);
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
            'city' => 'required',
            'has_contract' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect($back)
                ->withErrors($validator);
        }

        $address->name = $request->input('name');
        $address->street = $request->input('street');
        $address->zip = $request->input('zip');
        $address->city = $request->input('city');
        $address->has_contract = $request->input('has_contract') !== null;
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
        
        $rules = [
            'name' => 'required',
            'street' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'has_contract' => 'nullable|boolean',
        ];

        $messages = [
            'has_contract.*' => 'Dieser Wert ist ungültig'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect($back)
                ->withInput()
                ->withErrors($validator);
        }

        $shippingAddress = new ShippingAddress();
        $shippingAddress->name = $request->input('name');
        $shippingAddress->street = $request->input('street');
        $shippingAddress->zip = $request->input('zip');
        $shippingAddress->city = $request->input('city');
        $shippingAddress->has_contract = $request->input('has_contract') !== null;
        

        $customer->shippingAddresses()->save($shippingAddress);

        $shippingAddress->save();

        return redirect(route('customer.details', ['customerId' => $customerId]))
            ->with('success', 'Die Lieferadresse wurde angelegt');
    }
}
