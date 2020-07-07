<?php

namespace App\Models;

class StationComponentUploadFile extends UploadFile
{
    public function imagePath() {
        return "files/component/$this->fileId.$this->extension";
    }

    public function thumbnailPath() {
        return "files/component/thumbnail/$this->fileId.$this->extension";
    }

    public function component() {
        $className = substr(get_class($this), 0, 0 - strlen('UploadFile'));

        return $this->belongsTo($className, 'component_id', 'id');
    }
}
