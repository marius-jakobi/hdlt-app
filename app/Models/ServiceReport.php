<?php

namespace App\Models;

class ServiceReport extends AbstractUuidModel
{
    public function orderConfirmation() {
        return $this->belongsTo(OrderConfirmation::class, 'order_confirmation_id', 'id');
    }
}
