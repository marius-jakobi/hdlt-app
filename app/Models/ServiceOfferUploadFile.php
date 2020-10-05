<?php

namespace App\Models;

use App\Models\Service\ServiceOffer;

class ServiceOfferUploadFile extends UploadFile
{
    protected $fillable = [
        'fileId',
        'extension',
        'name'
    ];

    public function filePath() {
        return "files/service-offer/$this->fileId.$this->extension";
    }

    public function serviceOffer() {
        return $this->belongsTo(ServiceOffer::class, 'service_offer_id', 'id');
    }
}
