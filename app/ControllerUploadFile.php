<?php

namespace App;

class ControllerUploadFile extends UploadFile
{
    protected $table = "controller_upload_files";

    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
