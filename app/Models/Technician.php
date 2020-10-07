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

    public function getTimeFromHours($value) {
        $hours = floor($value);
        $minutes = ($value - $hours) * 60;
        if (intval($minutes) < 9) {
            $minutes = "0$minutes";
        }

        return "$hours:$minutes";
    }

    public function getTotalHours($start, $end) {
        return number_format($end - $start, 2, ",", ".");
    }

    /**
     * Relationships
     */

    public function serviceReports() {
        return $this->belongsToMany(ServiceReport::class, 'service_report_technicians', 'technician_id', 'service_report_id')
            ->withPivot(['work_time', 'work_date']);
    }
}
