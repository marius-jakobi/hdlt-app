<?php

namespace App;

class Separator extends StationComponent
{
    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }
}
