<?php

namespace App\Models;

class ShippingAddressUploadFile extends UploadFile
{
    protected $fillable = [
        'fileId', 'extension', 'name'
    ];

    public function imagePath() {
        return "files/shipping-address/$this->fileId.$this->extension";
    }

    public function thumbnailPath() {
        return "files/shipping-address/thumbnail/$this->fileId.$this->extension";
    }

    public function shippingAddress() {
        return $this->belongsTo('App\Models\ShippingAddress', 'shipping_address_id', 'id');
    }
}
