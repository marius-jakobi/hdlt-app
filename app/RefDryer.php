<?php

namespace App;

class RefDryer extends StationComponent
{
    public function getRefrigerant() {
        return "$this->ref_amount kg $this->ref_type";
    }

    public static function getRefTypes() {
        return ['R134a','R404A','R407C','R410A','R452a','R22'];
    }
}
