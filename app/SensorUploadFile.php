<?php

namespace App;

class SensorUploadFile extends UploadFile
{
    protected $table = "sensor_upload_files";

    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
