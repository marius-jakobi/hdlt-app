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
}
