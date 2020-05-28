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
        return $this->belongsToMany('App\Permission', 'roles_permissions');
    }

    /**
     * User relationship
     */
    public function users() {
        return $this->belongsToMany('App\User', 'users_roles');
    }

    /**
     * Check if role has permission
     */
    public function hasPermission(string $permissionName) {
        foreach ($this->permissions() as $permission) {
            if ($permission->name == $permissionName) {
                return true;
            }
        }
    }
}
