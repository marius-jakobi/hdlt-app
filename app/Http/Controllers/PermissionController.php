<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\Role;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Attach a permission to a role
     * 
     * @param Request $request
     * @param string $name Name of the role
     * @return RedirectResponse
     */
    public function attachPermissionToRole(Request $request, string $name) {
        $back = route('role.details', ['name' => $name]) . "#rights";

        $role = Role::firstWhere('name', $name);

        // Validation rules
        $rules = [
            'permission_id' => 'required|exists:App\Models\Permission,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Dieses Recht existiert nicht.',
            'required' => 'Es muss eine Recht angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect($back)
                ->withErrors($validator, 'attachPermission');
        }

        if ($role->isAdmin()) {
            return redirect($back)
                ->with('error', "Die Rechte der Administratorrolle können nicht geändert werden.");
        }

        $permission = Permission::find($request->input('permission_id'));

        if ($role->hasPermission($permission->name)) {
            return redirect($back)
                ->withErrors(["Die Rolle '$role->name' verfügt bereits über das Recht '$permission->name'."]);
        }

        $role->permissions()->attach($permission);
        $role->save();

        return redirect($back)
            ->with('success', 'Das Recht wurde der Rolle zugeordnet.');
    }

    /**
     * Detach a permission from a role
     * 
     * @param Request $request
     * @param string $name Name of the role
     * @return RedirectResponse
     */
    public function detachPermissionFromRole(Request $request, string $name) {
        $back = route('role.details', ['name' => $name]) . "#rights";

        $role = Role::firstWhere('name', $name);

        // Validation rules
        $rules = [
            'permission_id' => 'required|exists:App\Models\Permission,id'
        ];

        // Validation messages
        $messages = [
            'exists' => 'Dieses Recht existiert nicht.',
            'required' => 'Es muss eine Recht angegeben sein.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('role.details', ['name' => $name]))
                ->withErrors($validator, 'detachPermission');
        }

        if ($role->isAdmin()) {
            return redirect($back)
                ->with('error', "Die Rechte der Administratorrolle können nicht geändert werden.");
        }

        $permission = Permission::find($request->input('permission_id'));

        if (!$role->hasPermission($permission->name)) {
            return redirect(route('role.details', ['name' => $name]))
                ->withErrors(["Die Rolle '$role->name' verfügt nicht über das Recht '$permission->name'."]);
        }

        $role->permissions()->detach($permission);
        $role->save();

        return redirect($back)
        ->with('success', 'Das Recht wurde von der Rolle entfernt.');
    }

    /**
     * Show a list of all permissions
     * 
     * @return View
     */
    public function list() {
        return view('permission.list', ['permissions' => Permission::all()]);
    }

    /**
     * Show details of a permission
     * 
     * @param string $name Name of the permission
     * @return View
     */
    public function details(string $name) {
        $permission = Permission::where('name', $name)->firstOrFail();

        return view('permission.details', ['permission' => $permission]);
    }

    /**
     * Delete a permission
     * 
     * @param int $id - ID of the permission
     * @return RedirectResponse
     */
    public function delete(int $id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect(route('permission.list'))
            ->with('success', "Das Recht '$permission->name' wurde erfolgreich gelöscht.");
    }

    /**
     * Update a permission
     * 
     * @param Request $request
     * @param int $id ID of the permission
     * @return RedirectResponse
     */
    public function update(Request $request, int $id) {
        $permission = Permission::findOrFail($id);

        $this->authorize('update', $permission);

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

    /**
     * Show form to create a permission
     * 
     * @return View
     */
    public function create() {
        return view('permission.create');
    }

    /**
     * Store permission in database
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5|max:255|alpha_dash|unique:App\Models\Permission,name',
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
