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
     * Relationship to upload files
     */
    public function uploadedFiles() {
        return $this->hasMany('App\ShippingAddressUploadFile');
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
    public function ref_dryers() {
        return $this->hasMany('App\RefDryer', 'shipping_address_id', 'id');
    }
    public function filters() {
        return $this->hasMany('App\Filter', 'shipping_address_id', 'id');
    }
    public function ad_dryers() {
        return $this->hasMany('App\AdDryer', 'shipping_address_id', 'id');
    }
    public function adsorbers() {
        return $this->hasMany('App\Adsorber', 'shipping_address_id', 'id');
    }
    public function separators() {
        return $this->hasMany('App\Separator', 'shipping_address_id', 'id');
    }
    public function sensors() {
        return $this->hasMany('App\Sensor', 'shipping_address_id', 'id');
    }
    public function controllers() {
        return $this->hasMany('App\Controller', 'shipping_address_id', 'id');
    }
}
