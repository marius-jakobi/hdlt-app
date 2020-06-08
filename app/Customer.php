<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function billingAddress() {
        return $this->hasOne('App\BillingAddress');
    }

    public function shippingAddresses() {
        return $this->hasMany('App\ShippingAddress', 'customer_id', 'id');
    }
}
