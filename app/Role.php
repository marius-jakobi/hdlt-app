<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // This model needs no timestamps
    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    /**
     * Permission relationship
     */
    public function permissions() {
        return $this->hasMany('App\Permission');
    }

    /**
     * User relationship
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
