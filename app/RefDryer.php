<?php

namespace App;

class RefDryer extends StationComponent
{
    public static function getRefTypes() {
        return ['R134a','R404A','R407C','R410A','R452a','R22'];
    }
}
