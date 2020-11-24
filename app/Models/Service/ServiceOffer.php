<?php

namespace App\Models\Service;

use App\Models\Offer;
use App\Models\ServiceOfferUploadFile;
use App\Models\ShippingAddress;
use App\Rules\Week;

class ServiceOffer extends Offer {
    protected $fillable = [
        'shipping_address_id', 'sales_agent_id', 'offer_id', 'follow_up', 'contact_name', 'contact_phone', 'contact_mail'
    ];

    protected $dates = ['follow_up'];

    public function getStatusClass() {
        switch ($this->status) {
            case ServiceOfferStatus::OPEN: {
                return "badge badge-secondary";
            }
            case ServiceOfferStatus::DECLINED: {
                return "badge badge-danger";
            }
            case ServiceOfferStatus::ACCEPTED: {
                return "badge badge-success";
            }
            default: {
                return "badge badge-secondary";
            }
        }
    }

    public function getStatus() {
        switch ($this->status) {
            case ServiceOfferStatus::OPEN: {
                return "offen";
            }
            case ServiceOfferStatus::DECLINED: {
                return "abgelehnt";
            }
            case ServiceOfferStatus::ACCEPTED: {
                return "akzeptiert";
            }
            default: {
                return "N/A";
            }
        }
    }

    public function files() {
        return $this->hasMany(ServiceOfferUploadFile::class, 'service_offer_id');
    }

    public static function rules() {
        return [
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'offer_id' => 'required|regex:/^[0-9]{4}-1[0-9]{4}$/',
            'follow_up' => [
                'required',
                'after:now',
                new Week()
            ],
            'sales_agent_id' => 'required|exists:sales_agents,id',
            'contact_name' => 'required|string|max:64',
            'contact_phone' => 'required|string|max:64',
            'contact_mail' => 'required|email|max:64',
            'files' => [
                'required',
                'array',
                'min:1',
                // Check if at least one file is a pdf file
                function ($attribute, $value, $fail) {
                    // assume that array contains no pdf
                    $hasPdf = false;
                    foreach ($value as $file) {
                        if ($file->getClientMimeType() === 'application/pdf') {
                            // file is a pdf
                            $hasPdf = true;
                        }
                    }

                    // no pdf file found, return error
                    if (false === $hasPdf) {
                        $fail('Es muss mindestens ein Angebot im PDF-Format hochgeladen werden');
                    }
                }
            ],
            // validate mime types for jpeg, png and pdf
            'files.*' => 'file|mimetypes:application/pdf,image/jpeg,image/png|max:2000'
        ];
    }

    public static function messages() {
        return [
            'shipping_address_id.*' => 'Diese Lieferadresse ist ungültig',
            'offer_id.*' => 'Die Belegnummer ist ungültig',
            'follow_up.required' => 'Die Wiedervorlage muss angegeben werden',
            'follow_up.after' => 'Die Wiedervorlage muss in der Zukunft liegen',
            'follow_up.*' => 'Die Wiedervorlage ist ungültig',
            'sales_agent_id.*' => 'Ungültiger Vertreter',
            'contact_name.*' => 'Name ist ungültig (max. 64 Zeichen)',
            'contact_phone.*' => 'Telefonnummer ist ungültig (max. 64 Zeichen)',
            'contact_mail.*' => 'E-Mail ist ungültig',
            'files.*' => 'Es muss mindestens eine Datei hochgeladen werden',
            'files.*.mimetypes' => 'Es dürfen nur JPEG-, PNG- und PDF-Dateien hochgeladen werden',
            'files.*.max' => 'Eine Datei darf maximal 2 MB groß sein'
        ];
    }
}

abstract class ServiceOfferStatus {
    const OPEN = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;
}
