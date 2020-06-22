<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use App\ShippingAddressUploadFile;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Upload a image to a shipping address
     */
    public function uploadShippingAddressFile(Request $request, int $customerId, int $addressId) {
        $path = $request->file('file')->store('files/shipping-address');

        $file = new ShippingAddressUploadFile([
            'name' => $request->input('name'),
            'path' => $path
        ]);

        $file->shippingAddress()->associate(ShippingAddress::findOrFail($addressId));
        $file->save();

        return redirect(route('customer.addresses.shipping.details', [
            'customerId' => $customerId,
            'addressId' => $addressId
        ]). '#files')
        ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }
}
