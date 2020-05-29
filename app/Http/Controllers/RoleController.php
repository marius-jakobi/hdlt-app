<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function attachRoleToUser(Request $request, string $id) {
        // Validation rules
        $rules = [
            'role_id' => 'required|exists:App\Role,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Diese Rolle existiert nicht.',
            'required' => 'Es muss eine Rolle angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors($validator, 'attachRole');
        }

        $user = User::findOrFail($id);
        $role = Role::find($request->input('role_id'));

        if ($user->hasRole($role->name)) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors(["Der Benutzer hat die Rolle '$role->name' bereits."]);
        }

        $user->roles()->attach($role);
        $user->save();

        return redirect(route('user.details', ['id' => $id]));
    }

    public function detachRoleFromUser(Request $request, $id) {
        // Validation rules
        $rules = [
            'role_id' => 'required|exists:App\Role,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Diese Rolle existiert nicht.',
            'required' => 'Es muss eine Rolle angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors($validator, 'detachRole');
        }

        $user = User::findOrFail($id);
        $role = Role::find($request->input('role_id'));

        if (!$user->hasRole($role->name)) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors(["Der Benutzer hat die Rolle '$role->name' nicht."]);
        }

        $user->roles()->detach($role);
        $user->save();

        return redirect(route('user.details', ['id' => $id]));
    }
}
