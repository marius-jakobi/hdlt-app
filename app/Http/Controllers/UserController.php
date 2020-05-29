<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;

class UserController extends Controller
{
    public function profile() {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function list() {
        return view('user.list', ['users' => User::orderBy('name_last', 'asc')->get()]);
    }

    public function details($id) {
        $user = User::findOrFail($id);
        
        $availableRoles = [];

        foreach (Role::all() as $role) {
            if (!$user->hasRole($role->name)) {
                $availableRoles[] = $role;
            }
        }

        return view('user.details', ['user' => $user, 'availableRoles' => Role::all()]);
    }
}
