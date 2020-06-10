<?php

namespace App\Http\Controllers;

use App\AdDryer;
use App\Adsorber;
use App\ShippingAddress;
use App\StationComponent;
use App\Brand;
use App\Compressor;
use App\Filter;
use App\Receiver;
use App\RefDryer;
use App\Sensor;
use App\Separator;
use Illuminate\Support\Facades\Validator;
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
        if (!StationComponent::isValidType($type)) {
            return abort(404);
        }

        return view('component.create', [
            'shippingAddress' => ShippingAddress::findOrFail($addressId),
            'type' => $type,
            'caption' => StationComponent::types()[$type],
            'brands' => Brand::orderBy('name')->get(),
            'refTypes' => ['R134a','R404A','R407C','R410A','R452a','R22']
        ]);
    }

    /**
     * Store component in db
     * 
     * @param Request $request
     * @param int $customerId
     * @param int $addressId
     * @param string $type
     * @return RedirectResponse
     */
    public function store(Request $request, $customerId, $addressId, $type) {
        if (!StationComponent::isValidType($type)) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), StationComponent::getValidationRules($type));

        $back = route('component.create', ['customerId' => $customerId, 'addressId' => $addressId, 'type' => $type]);
        
        if ($validator->fails()) {
            return redirect($back)
                ->withErrors($validator)
                ->withInput();
        }

        $component = $this->createComponent($type, $request->all());
        $component->shippingAddress()->associate(ShippingAddress::find($addressId));
        $component->save();

        return redirect(route('customer.addresses.shipping.details', ['customerId' => $customerId, 'addressId' => $addressId]))
            ->with('success', 'Die Komponente wurde angelegt');
    }

    private function createComponent(string $type, array $input) {
        unset($input['_token']);
        
        switch ($type) {
            case "compressor":
                $component = new Compressor($input);
            break;
            case "receiver":
                $component = new Receiver($input);
            break;
            case "filter":
                $component = new Filter($input);
            break;
            case "ref_dryer":
                $component = new RefDryer($input);
            break;
            case "ad_dryer":
                $component = new AdDryer($input);
            break;
            case "adsorber":
                $component = new Adsorber($input);
            break;
            case "separator":
                $component = new Separator($input);
            break;
            case "sensor":
                $component = new Sensor($input);
            break;
            case "controller":
                $component = new \App\Controller($input);
            break;
        }

        return $component;
    }
}
