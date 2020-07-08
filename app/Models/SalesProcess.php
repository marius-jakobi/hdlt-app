<?php

namespace App\Models;

class SalesProcess extends Process
{
    protected $table = 'process_sales';

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function orderConfirmations() {
        return $this->hasMany(OrderConfirmation::class, 'sales_process_id', 'id');
    }
}
