<?php

namespace App;

class CompressorUploadFile extends UploadFile
{
    protected $table = "compressor_upload_files";

    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
