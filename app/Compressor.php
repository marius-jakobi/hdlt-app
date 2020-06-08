<?php

namespace App;

class Compressor extends StationComponent
{
    /**
     * Types
     */
    private $types = [
        'screw' => 'Schraubenkompressor',
        'piston' => 'Kolbenkompressor',
        'rotation' => 'Rotationskompressor',
        'scroll' => 'Scroll-Kompressor'
    ];

    /**
     * Helper for getting type
     */
    public function getType() {
        return $this->types[$this->type];
    }
}
