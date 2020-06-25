<?php

namespace App;

class Sensor extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }
}
