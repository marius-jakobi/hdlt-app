<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use App\ShippingAddressUploadFile;
use App\StationComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    protected $rules = [
        'name' => 'required|min:6|max:255',
        'file' => 'required|file|mimetypes:image/*'
    ];

    protected $messages = [
        'name.required' => 'Geben Sie eine Bezeichnung für die Datei ein',
        'file.required' => 'Wählen Sie eine Datei aus',
        'file.mimetypes' => 'Die Datei muss eine Bilddatei sein',
    ];

    /**
     * Upload a image to a shipping address
     */
    public function uploadShippingAddressFile(Request $request, int $customerId, int $addressId) {
        $back = route('customer.addresses.shipping.details', [
            'customerId' => $customerId,
            'addressId' => $addressId
        ]). '#files';

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

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

    public function uploadComponentFile(Request $request, int $customerId, int $addressId, string $type, int $componentId) {
        $componentClass = '\App\\' . StationComponent::getComponentClassname($type);
        $uploadClass = $componentClass . 'UploadFile';

        $back = route('component.details', [
            'customerId' => $customerId,
            'addressId' => $addressId,
            'type' => $type,
            'componentId' => $componentId
            ])
            . '#files';

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect($back)
                ->withInput()
                ->withErrors($validator, 'files');
        }

        $path = $request->file('file')->store('files/component');

        $file = new $uploadClass([
            'name' => $request->input('name'),
            'path' => $path
        ]);

        $file->component()->associate($componentClass::find($componentId));
        $file->save();

        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }
}
