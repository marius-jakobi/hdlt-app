<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_first', 'name_last', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Role relationship
     */
    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'users_roles');
    }

    /**
     * Check if user has role
     */
    public function hasRole(string $roleName) {
        foreach ($this->roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
    }

    public function hasPermission(string $name) {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($name)) {
                return true;
            }
        }
    }

    /**
     * Return short name
     */
    public function shortName() {
      return substr($this->name_first, 0, 1) . ". " . $this->name_last;
    }

    public function isAdmin() {
        return $this->email == User::administratorEmail();
    }

    public function hasAdminRole() {
        return $this->hasRole(Role::administratorRoleName());
    }

    public static function administratorEmail() {
        return "administrator@" . env('APP_HOST');
    }
}
