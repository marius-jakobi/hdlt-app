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

    public function getStatusClass() {
        switch ($this->status) {
            case ServiceOfferStatus::OPEN: {
                return "badge badge-secondary";
            }
            case ServiceOfferStatus::DECLINED: {
                return "badge badge-danger";
            }
            case ServiceOfferStatus::ACCEPTED: {
                return "badge badge-success";
            }
            default: {
                return "badge badge-secondary";
            }
        }
    }

    public function getStatus() {
        switch ($this->status) {
            case ServiceOfferStatus::OPEN: {
                return "offen";
            }
            case ServiceOfferStatus::DECLINED: {
                return "abgelehnt";
            }
            case ServiceOfferStatus::ACCEPTED: {
                return "akzeptiert";
            }
            default: {
                return "N/A";
            }
        }
    }

    public function files() {
        return $this->hasMany(ServiceOfferUploadFile::class, 'service_offer_id');
    }
}

abstract class ServiceOfferStatus {
    const OPEN = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;
}
