<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
    public function salesProcess() {
        return $this->belongsTo(ProcessSales::class, 'sales_process_id', 'id');
    }
}
