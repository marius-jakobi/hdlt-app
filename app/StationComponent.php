<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StationComponent extends Model
{
    private static $types = [
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

    public static function types() {
        return self::$types;
    }

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
}
