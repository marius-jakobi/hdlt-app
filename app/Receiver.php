<?php

namespace App;

class Receiver extends StationComponent
{
    /**
     * Types
     */
    private $types = [
        'standing' => 'stehend',
        'lying' => 'liegend'
    ];

    /**
     * Helper for getting type
     */
    public function getType() {
        return $this->types[$this->type];
    }
}
