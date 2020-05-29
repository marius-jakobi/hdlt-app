<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Role;
use App\Permission;

class PermissionController extends Controller
{
    public function attachPermissionToRole(Request $request, string $name) {
        // Validation rules
        $rules = [
            'permission_id' => 'required|exists:App\Permission,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Dieses Recht existiert nicht.',
            'required' => 'Es muss eine Recht angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        $role = Role::where('name', $name)->first();

        if ($validator->fails()) {
            return redirect(route('role.details', ['name' => $role->name]))
                ->withErrors($validator, 'attachPermission');
        }

        $permission = Permission::find($request->input('permission_id'));

        if ($role->hasPermission($permission->name)) {
            return redirect(route('role.details', ['name' => $role->name]))
                ->withErrors(["Die Rolle '$role->name' verfügt bereits über das Recht '$permission->name'."]);
        }

        $role->permissions()->attach($permission);
        $role->save();

        return redirect(route('role.details', ['name' => $role->name]))
            ->with('success', 'Das Recht wurde der Rolle zugeordnet.');
    }

    public function detachPermissionFromRole(Request $request, $name) {
        // Validation rules
        $rules = [
            'permission_id' => 'required|exists:App\Permission,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Dieses Recht existiert nicht.',
            'required' => 'Es muss eine Recht angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        $role = Role::firstWhere('name', $name);

        if ($validator->fails()) {
            return redirect(route('role.details', ['name' => $name]))
                ->withErrors($validator, 'detachPermission');
        }

        $permission = Permission::find($request->input('permission_id'));

        if (!$role->hasPermission($permission->name)) {
            return redirect(route('role.details', ['name' => $name]))
                ->withErrors(["Die Rolle '$role->name' verfügt nicht über das Recht '$permission->name'."]);
        }

        $role->permissions()->detach($permission);
        $role->save();

        return redirect(route('role.details', ['name' => $name]))
        ->with('success', 'Das Recht wurde von der Rolle entfernt.');
    }
}
