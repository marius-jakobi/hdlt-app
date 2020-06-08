<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StationComponent extends Model
{
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
