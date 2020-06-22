<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use App\ShippingAddressUploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    /**
     * Upload a image to a shipping address
     */
    public function uploadShippingAddressFile(Request $request, int $customerId, int $addressId) {
        $back = route('customer.addresses.shipping.details', [
            'customerId' => $customerId,
            'addressId' => $addressId
        ]). '#files';

        $rules = [
            'name' => 'required|min:6|max:255',
            'file' => 'required|file|mimetypes:image/*'
        ];

        $messages = [
            'name.required' => 'Geben Sie eine Bezeichnung für die Datei ein',
            'file.required' => 'Wählen Sie eine Datei aus',
            'file.mimetypes' => 'Die Datei muss eine Bilddatei sein',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect($back)
                ->withErrors($validator, 'files');
        }

        $path = $request->file('file')->store('files/shipping-address');

        $file = new ShippingAddressUploadFile([
            'name' => $request->input('name'),
            'path' => $path
        ]);

        $file->shippingAddress()->associate(ShippingAddress::findOrFail($addressId));
        $file->save();

        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }
}
