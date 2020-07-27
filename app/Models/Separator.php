<?php

namespace App\Models;

class Separator extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }

    public function serviceReports() {
        return $this->belongsToMany(ServiceReport::class, 'separators_service_reports', 'component_id', 'service_report_id');
    }
}
