<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $fillable = ['name', 'street', 'zip', 'city'];

    /**
     * Relationship to customer
     */
    public function customer() {
        return $this->belongsTo('App\Customer');
    }
}
