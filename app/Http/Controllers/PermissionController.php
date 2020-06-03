<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function list() {
        return view('permission.list', ['permissions' => Permission::all()]);
    }

    public function details($name) {
        $permission = Permission::where('name', $name)->firstOrFail();

        return view('permission.details', ['permission' => $permission]);
    }

    public function delete($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect(route('permission.list'))
            ->with('success', "Das Recht '$permission->name' wurde erfolgreich gelöscht.");
    }

    public function update(Request $request, $id) {
        $permission = Permission::findOrFail($id);

        $rules = [
            'name' => [
                'required',
                'min:5',
                'max:255',
                'alpha_dash',
                Rule::unique('permissions')->ignore($permission)
            ],
            'description' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('permission.details', ['name' => $permission->name]))
                ->withErrors($validator);
        }

        $permission->name = $request->input('name');
        $permission->description = $request->input('description');

        $permission->save();

        return redirect(route('permission.details', ['name' => $permission->name]))
            ->with('success', "Das Recht wurde aktualisiert.");
    }

    public function create() {
        return view('permission.create');
    }

    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5|max:255|alpha_dash|unique:App\Permission,name',
            'description' => 'required|max:255'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return redirect(route('permission.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $permission = new Permission([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $permission->save();

        $adminRole = Role::where('name', Role::administratorRoleName())->firstOrFail();
        $adminRole->permissions()->attach($permission);
        $adminRole->save();

        return redirect(route('permission.details', ['name' => $permission->name]))
            ->with('success', "Das Recht '$permission->name' wurde gespeichert.");
    }
}
