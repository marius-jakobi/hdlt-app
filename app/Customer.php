<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['cust_id', 'description'];
    
    public function billingAddress() {
        return $this->hasOne('App\BillingAddress');
    }

    public function shippingAddresses() {
        return $this->hasMany('App\ShippingAddress', 'customer_id', 'id');
    }
}
