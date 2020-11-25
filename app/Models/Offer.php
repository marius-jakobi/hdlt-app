<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {
    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function followUps() {
        return $this->hasMany(ServiceOfferFollowUp::class, 'service_offer_id', 'id')->orderBy('created_at');
    }

    public function recentFollowUp() {
        return $this->followUps()->first();
    }

    public function salesAgent() {
        return $this->belongsTo(SalesAgent::class, 'sales_agent_id', 'id');
    }
}
