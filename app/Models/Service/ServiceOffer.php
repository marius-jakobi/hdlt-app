<?php

namespace App\Models\Service;

use App\Models\Offer;
use App\Models\ServiceOfferUploadFile;
use App\Models\ShippingAddress;

class ServiceOffer extends Offer {
    protected $fillable = [
        'shipping_address_id', 'sales_agent_id', 'offer_id', 'follow_up', 'contact_name', 'contact_phone', 'contact_mail'
    ];

    protected $dates = ['follow_up'];

    public function getFollowUpAttribute($value) {
        $date = new \Carbon\Carbon($value);
        return $date->weekOfYear . "/" . $date->year;
    }

    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function files() {
        return $this->hasMany(ServiceOfferUploadFile::class, 'service_offer_id');
    }
}