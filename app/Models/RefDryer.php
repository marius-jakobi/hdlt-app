<?php

namespace App\Models;

class RefDryer extends StationComponent
{
    protected static $refTypes = [
        'R134a' => [
            'gwp' => 1430,
            'forbidden' => false
        ],
        'R404A' => [
            'gwp' => 3920,
            'forbidden' => false
        ],
        'R407C' => [
            'gwp' => 1770,
            'forbidden' => false
        ],
        'R410A' => [
            'gwp' => 2090,
            'forbidden' => false
        ],
        'R452a' => [
            'gwp' => 2140,
            'forbidden' => false
        ],
        'R22' => [
            'gwp' => 1810,
            'forbidden' => true
        ]
    ];

    public static function getRefTypes() {
        return static::$refTypes;
    }

    public function hasForbiddenRefType() {
        $refType = $this->getRefTypes()[$this->ref_type];

        if ($refType['forbidden'] === true) {
            return true;
        }
    }

    public function getCO2Equivalent() {
        if (!$this->ref_amount) {
            return "N/A";
        }

        $refType = $this->getRefTypes()[$this->ref_type];

        return str_replace('.', ',', round($refType['gwp'] * $this->ref_amount / 1000, 3));
    }

    public static function getRefTypeNames() {
        $refTypeNames = [];
        foreach (static::$refTypes as $key => $value) {
            $refTypeNames[] = $key;
        }

        return $refTypeNames;
    }

    public function uploadedFiles() {
        return $this->hasMany(get_class($this) . 'UploadFile', 'component_id');
    }
}
