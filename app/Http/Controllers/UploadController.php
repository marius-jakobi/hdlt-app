<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use App\Models\ShippingAddressUploadFile;
use App\Models\StationComponent;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    protected $rules = [
        'name' => 'required|min:4|max:255',
        'files' => 'required|array|min:1',
        'files.*' => 'required|file|mimes:png,jpeg'
    ];

    protected $messages = [
        'name.required' => 'Geben Sie eine Beschreibung für die Dateien ein',
        'files.required' => 'Bilddateien auswählen',
        'files.mimetypes' => 'Die Dateien müssen Bilddateien (PNG oder JPEG) sein',
    ];

    private function storeFile(string $type, UploadedFile $file) {
        if (!in_array($type, ['shipping-address', 'component'])) {
            throw new \Exception("\$type must be 'shipping-address' or 'component'. '$type' given");
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $fileId = Str::uuid();
        $fileName = "files/$type/$fileId.$extension";
        $thumbnailFilename = "files/$type/thumbnail/$fileId.$extension";

        Image::make($file)->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($fileName);

        Image::make($file)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailFilename);

        return [
            'fileId' => $fileId,
            'extension' => $extension
        ];
    }

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
                ->withInput()
                ->withErrors($validator, 'files');
        }

        $files = $request->file('files');

        foreach ($files as $file) {
            $img = $this->storeFile('shipping-address', $file);
    
            $uploadFile = new ShippingAddressUploadFile([
                'name' => $request->input('name'),
                'fileId' => $img['fileId'],
                'extension' => $img['extension']
            ]);

            $uploadFile->shippingAddress()->associate(ShippingAddress::findOrFail($addressId));
            $uploadFile->save();
        }

        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }

    public function uploadComponentFile(Request $request, string $type, int $componentId) {
        $back = route('component.details', [
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

        $componentClass = StationComponent::getComponentClassname($type);
        $uploadClass = $componentClass . 'UploadFile';

        $files = $request->file('files');

        foreach ($files as $file) {    
            $img = $this->storeFile('component', $file);
    
            $uploadFile = new $uploadClass([
                'name' => $request->input('name'),
                'fileId' => $img['fileId'],
                'extension' => $img['extension']
            ]);
    
            $uploadFile->component()->associate($componentClass::find($componentId));
            $uploadFile->save();
        }


        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }
}
