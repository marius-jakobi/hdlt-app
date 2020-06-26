<?php

namespace App\Models;

class StationComponentUploadFile extends UploadFile
{
    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
