<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    /**
     * Type cast
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relationships
     */

    public function serviceReports() {
        return $this->belongsToMany(ServiceReport::class, 'service_report_technicians', 'technician_id', 'service_report_id')
            ->withPivot(['work_time', 'work_date']);
    }
}
