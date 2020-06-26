<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // This model needs no timestamps
    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    /**
     * Role relationship
     */
    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'roles_permissions');
    }
}
