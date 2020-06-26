<?php

namespace App\Models;

class ShippingAddressUploadFile extends UploadFile
{
    public function shippingAddress() {
        return $this->belongsTo('App\Models\ShippingAddress', 'shipping_address_id', 'id');
    }
}
