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

    public function salesProcess() {
        return $this->orderConfirmation->salesProcess();
    }

    public function technicians() {
        return $this->belongsToMany(Technician::class, 'service_report_technicians', 'service_report_id', 'technician_id')
            ->withPivot(['work_time']);
    }

    public function getLocalDate() {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d.m.Y');
    }

    public function getTotalWorktime() {
        $totalWorktime = 0;
        
        foreach ($this->technicians as $technician) {
            $totalWorktime += $technician->pivot->work_time;
        }

        return $totalWorktime;
    }
}
