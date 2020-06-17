<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class StationComponent extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'brand_id',
        'model',
        'volume',
        'element',
        'serial',
        'year',
        'pressure',
        'ref_type',
        'ref_amount',
        'is_active',
        'is_oilfree',
        'next_service',
        'memo'
    ];

    /**
     * Brand relationship
     */
    public function brand() {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    /**
     * Shipping address relationship
     */
    public function shippingAddress() {
        return $this->belongsTo('App\ShippingAddress', 'shipping_address_id', 'id');
    }

    /**
     * Type cast
     */
    protected $casts = [
        'is_oilfree' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * valid component types
     */
    protected static $componentTypes = [
        'compressor' => 'Kompressor',
        'receiver' => 'Behälter',
        'ref_dryer' => 'Kältetrockner',
        'filter' => 'Filter',
        'ad_dryer' => 'Adsorptionstrockner',
        'adsorber' => 'Öldampfadsorber',
        'separator' => 'Öl-Wasser-Trenner',
        'sensor' => 'Sensor',
        'controller' => 'Steuerung'
    ];

    /**
     * Getter for types
     * 
     * @return string
     */
    public static function types() {
        return self::$componentTypes;
    }

    /**
     * Check if type is valid
     * 
     * @param string $type Type of component
     * @return bool Type is valid or not
     */
    public static function isValidType($type) {
        $validType = false;

        foreach (self::$componentTypes as $key => $value) {
            if ($type === $key) {
                $validType = true;
            }
        }

        return $validType;
    }

    /**
     * Get validation rules array
     * 
     * @param string $type Type of component
     * @return array Array with validation rules for given component type
     */
    public static function getValidationRules($type) {
        $validationRules = ['brand_id' => 'exists:brands,id'];

        if ($type !== 'receiver') {
            $validationRules['model'] = 'required';
        } else {
            $validationRules['volume'] = 'required|numeric|min:0|max:100000';
        }

        if ($type === 'compressor' || $type === 'receiver' || $type ==='ad_dryer' || $type === 'adsorber' || $type === 'ref_dryer') {
            $validationRules['serial'] = 'required';
            $validationRules['year'] = 'required|integer|min:1900|max:3000';
            
            if ($type === 'compressor' || $type === 'receiver') {
                $validationRules['pressure'] = 'required|numeric|min:0|max:1000';
            }
        }

        if ($type === 'filter') {
            $validationRules['element'] = 'required';
        }

        if ($type === 'ref_dryer') {
            $validationRules['ref_type'] = [
                'required',
                Rule::in(RefDryer::getRefTypes())
            ];
            $validationRules['ref_amount'] = 'required|numeric|min:0|max:100';
        }

        return $validationRules;
    }
}
