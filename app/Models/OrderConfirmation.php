<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderConfirmation extends Model
{
    protected $fillable = ['document_number', 'sales_process_id', 'po_number'];
    
    public function salesProcess() {
        return $this->belongsTo(SalesProcess::class, 'sales_process_id', 'id');
    }

    public function serviceReports() {
        return $this->hasMany(ServiceReport::class, 'order_confirmation_id', 'id');
    }
}
