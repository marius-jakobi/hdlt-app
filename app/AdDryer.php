<?php

namespace App;

class AdDryer extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany('\\'.get_class($this).'UploadFile', 'component_id');
    }
}
