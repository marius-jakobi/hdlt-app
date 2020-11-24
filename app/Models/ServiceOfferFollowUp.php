<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOfferFollowUp extends Model
{
    public $timestamps = false;

    protected $fillable = ['follow_up', 'text', 'created_at'];

    protected $dates = ['follow_up', 'created_at'];
}
