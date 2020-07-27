<?php

namespace App\Models;

class AdDryer extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany('\\'.get_class($this).'UploadFile', 'component_id');
    }

    public function serviceReports() {
        return $this->belongsToMany(ServiceReport::class, 'ad_dryers_service_reports', 'component_id', 'service_report_id');
    }
}
