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
        'name' => 'required|min:6|max:255',
        'file' => 'required|file|mimetypes:image/png,image/jpeg'
    ];

    protected $messages = [
        'name.required' => 'Geben Sie eine Bezeichnung für die Datei ein',
        'file.required' => 'Wählen Sie eine Datei aus',
        'file.mimetypes' => 'Die Datei muss eine Bilddatei (PNG oder JPEG) sein',
    ];

    private function storeFile(string $type, UploadedFile $file) {
        if (!in_array($type, ['shipping-address', 'component'])) {
            throw new \Exception("\$type must be 'shipping-address' or 'component'. '$type' given");
        }

        $mimeType = explode('/', getimagesize($file)['mime']);
        $fileType = end($mimeType);
        $uuid = Str::uuid();
        $fileName = "files/$type/$uuid.$fileType";
        $thumbnailFilename = "files/$type/thumbnail/$uuid.$fileType";

        Image::make($file)->resize(1500, 1500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($fileName);

        Image::make($file)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailFilename);

        return [
            'fileId' => $uuid,
            'extension' => $fileType
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
                ->withErrors($validator, 'files');
        }

        $img = $this->storeFile('shipping-address', $request->file('file'));

        $file = new ShippingAddressUploadFile([
            'name' => $request->input('name'),
            'fileId' => $img['fileId'],
            'extension' => $img['extension']
        ]);

        $file->shippingAddress()->associate(ShippingAddress::findOrFail($addressId));
        $file->save();

        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }

    public function uploadComponentFile(Request $request, int $customerId, int $addressId, string $type, int $componentId) {
        $componentClass = '\App\\Models\\' . StationComponent::getComponentClassname($type);
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

        $img = $this->storeFile('component', $request->file('file'));

        $file = new $uploadClass([
            'name' => $request->input('name'),
            'fileId' => $img['fileId'],
            'extension' => $img['extension']
        ]);

        $file->component()->associate($componentClass::find($componentId));
        $file->save();

        return redirect($back)
            ->with('success', 'Die Datei wurde erfolgreich hochgeladen.');
    }
}
