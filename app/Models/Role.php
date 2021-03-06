<?php

namespace App\Models;

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
        return $this->belongsToMany('App\Models\Permission', 'roles_permissions');
    }

    /**
     * User relationship
     */
    public function users() {
        return $this->belongsToMany('App\Models\User', 'users_roles');
    }

    /**
     * Check if role has permission
     */
    public function hasPermission(string $permissionName) {
        foreach ($this->permissions as $permission) {
            if ($permission->name == $permissionName) {
                return true;
            }
        }
    }

    public static function administratorRoleName() {
        return "Administrator";
    }

    public function isAdmin() {
        return $this->name === $this->administratorRoleName();
    }
}
