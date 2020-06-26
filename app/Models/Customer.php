<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['cust_id', 'description'];
    
    public function billingAddress() {
        return $this->hasOne('App\Models\BillingAddress');
    }

    public function shippingAddresses() {
        return $this->hasMany('App\Models\ShippingAddress', 'customer_id', 'id');
    }
}
