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
            'text' => 'required|max:255|min:10',
            'follow_up' => [
                'required',
                'after:now',
                new Week()
            ]
        ];
    }

    public static function messages() {
        return [
            'follow_up.after' => 'Die Kalenderwoche muss in der Zukunft liegen'
        ];
    }
}
