<?php

namespace App\Models;

use App\SalesAgent;
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

    public function payterms() {
        return $this->hasOne(Payterms::class, 'payterms_id', 'id');
    }

    public function salesAgent() {
        return $this->hasOne(SalesAgent::class, 'payterms_id', 'id');
    }

    public function salesProcesses() {
        return $this->hasMany(SalesProcess::class, 'customer_id', 'id');
    }
}
