<?php

namespace App\Models;

class Receiver extends StationComponent
{
    /**
     * Types
     */
    protected static $types = [
        'standing' => 'stehend',
        'lying' => 'liegend'
    ];

    /**
     * Helper for getting type
     */
    public function getType() {
        return static::$types[$this->type];
    }

    public static function getTypes() {
        return static::$types;
    }

    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }

    public function serviceReports() {
        return $this->belongsToMany(ServiceReport::class, 'receivers_service_reports', 'component_id', 'service_report_id');
    }
}
