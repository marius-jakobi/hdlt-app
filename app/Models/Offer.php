<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class);
    }
}