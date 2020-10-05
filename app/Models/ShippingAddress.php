<?php

namespace App\Models;

use App\Models\Service\ServiceOffer;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = ['name', 'street', 'zip', 'city', 'has_contract'];

    protected $casts = [
        'has_contract' => 'boolean'
    ];

    /**
     * Relationship to customer
     */
    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * Relationship to service reports
     */
    public function serviceReports() {
        return $this->hasMany(ServiceReport::class, 'shipping_address_id', 'id');
    }

    /**
     * Relationship to upload files
     */
    public function uploadedFiles() {
        return $this->hasMany('App\Models\ShippingAddressUploadFile');
    }

    /**
     * Relationship to service offers
     */
    public function serviceOffers() {
        return $this->hasMany(ServiceOffer::class, 'shipping_address_id', 'id');
    }

    /**
     * Relationships to components
     */
    public function compressors() {
        return $this->hasMany('App\Models\Compressor', 'shipping_address_id', 'id');
    }

    public function receivers() {
        return $this->hasMany('App\Models\Receiver', 'shipping_address_id', 'id');
    }

    public function ref_dryers() {
        return $this->hasMany('App\Models\RefDryer', 'shipping_address_id', 'id');
    }

    public function filters() {
        return $this->hasMany('App\Models\Filter', 'shipping_address_id', 'id');
    }

    public function ad_dryers() {
        return $this->hasMany('App\Models\AdDryer', 'shipping_address_id', 'id');
    }

    public function adsorbers() {
        return $this->hasMany('App\Models\Adsorber', 'shipping_address_id', 'id');
    }

    public function separators() {
        return $this->hasMany('App\Models\Separator', 'shipping_address_id', 'id');
    }

    public function sensors() {
        return $this->hasMany('App\Models\Sensor', 'shipping_address_id', 'id');
    }

    public function controllers() {
        return $this->hasMany('App\Models\Controller', 'shipping_address_id', 'id');
    }

    public function countComponents() {
        return $this->compressors->count() +
            $this->receivers->count() +
            $this->ref_dryers->count() +
            $this->filters->count() +
            $this->ad_dryers->count() +
            $this->adsorbers->count() +
            $this->separators->count() +
            $this->sensors->count() +
            $this->controllers->count();
    }
}
