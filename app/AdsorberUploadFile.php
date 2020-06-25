<?php

namespace App;

class AdsorberUploadFile extends UploadFile
{
    protected $table = "adsorber_upload_files";

    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
