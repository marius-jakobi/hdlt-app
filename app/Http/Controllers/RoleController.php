<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
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

    public function details($name) {
        $role = Role::where('name', $name)->firstOrFail();

        $availablePermissions = [];

        foreach (Permission::all() as $permission) {
            if (!$role->hasPermission($permission->name)) {
                $availablePermissions[] = $permission;
            }
        }

        return view('role.details', ['role' => $role, 'availablePermissions' => $availablePermissions]);
    }

    public function create() {
        return view('role.create');
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5|max:255|unique:App\Role',
            'description' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('role.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $role = new Role([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $role->save();

        return redirect(route('role.list'))->with('success', "Die Rolle '$role->name' wurde gespeichert.");
    }

    public function list() {
        return view('role.list', ['roles' => Role::all()]);
    }

    public function delete($id) {
        $role = Role::findOrFail($id);

        $role->delete();

        return redirect(route('role.list'))
            ->with('success', "Die Rolle wurde gelöscht.");
    }
}
