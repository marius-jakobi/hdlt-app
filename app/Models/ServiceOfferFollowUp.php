<?php

namespace App\Models;

use App\Rules\Week;
use Illuminate\Database\Eloquent\Model;

class ServiceOfferFollowUp extends Model
{
    public $timestamps = false;

    protected $fillable = ['follow_up', 'text'];

    protected $dates = ['follow_up', 'created_at'];

    public static function rules() {
        return [
            'text' => 'required|max:255',
            'follow_up' => [
                'required',
                'after:now',
                new Week()
            ]
        ];
    }
}
