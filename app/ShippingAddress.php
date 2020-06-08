<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = ['name', 'street', 'zip', 'city'];

    /**
     * Relationship to customer
     */
    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Relationships to components
     */
    public function compressors() {
        return $this->hasMany('App\Compressor', 'shipping_address_id', 'id');
    }
    public function receivers() {
        return $this->hasMany('App\Receiver', 'shipping_address_id', 'id');
    }
}
