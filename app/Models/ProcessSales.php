<?php

namespace App\Models;

class ProcessSales extends Process
{
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
