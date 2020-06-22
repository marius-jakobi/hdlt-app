<?php

namespace App;

class ShippingAddressUploadFile extends UploadedFile
{
    public function shippingAddress() {
        return $this->belongsTo('App\ShippingAddress', 'shipping_address_id', 'id');
    }
}
