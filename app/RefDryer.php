<?php

namespace App;

class RefDryer extends StationComponent
{
    public function getRefrigerant() {
        return "$this->ref_amount kg $this->ref_type";
    }
}
