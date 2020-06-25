<?php

namespace App;

class Compressor extends StationComponent
{
    /**
     * Types
     */
    protected static $types = [
        'screw' => 'Schraubenkompressor',
        'piston' => 'Kolbenkompressor',
        'rotation' => 'Rotationskompressor',
        'scroll' => 'Scroll-Kompressor'
    ];

    /**
     * Helper for getting type
     */
    public function getType() {
        return static::$types[$this->type];
    }

    public static function getTypes() {
        return static::$types;
    }

    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }
}
