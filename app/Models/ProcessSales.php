<?php

namespace App\Models;

class ProcessSales extends Process
{
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function orderConfirmations() {
        return $this->hasMany(OrderConfirmation::class, 'sales_process_id', 'id');
    }
}
