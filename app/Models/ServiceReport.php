<?php

namespace App\Models;

class ServiceReport extends AbstractUuidModel
{
    public function orderConfirmation() {
        return $this->belongsTo(OrderConfirmation::class, 'order_confirmation_id', 'id');
    }

    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id', 'id');
    }

    public function getLocalDate() {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d.m.Y');
    }
}
