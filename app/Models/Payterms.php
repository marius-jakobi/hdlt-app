<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payterms extends Model
{
    protected $fillable = ['short', 'full'];

    public function customer() {
        return $this->belongsToMany('App\Models\Customer', 'payterms_id', 'id');
    }
}
