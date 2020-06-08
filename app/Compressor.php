<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compressor extends Model
{
    /**
     * Types
     */
    private $types = [
        'screw' => 'Schraubenkompressor',
        'piston' => 'Kolbenkompressor',
        'rotation' => 'Rotationskompressor',
        'scroll' => 'Scroll-Kompressor'
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
     * Helper for getting type
     */
    public function getType() {
        return $this->types[$this->type];
    }
}
