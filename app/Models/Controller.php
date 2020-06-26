<?php

namespace App\Models;

class Controller extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }
}
