<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Attach role to user
     * 
     * @param Request $request
     * @param int $id ID of the user
     * @return RedirectResponse
     */
    public function attachRoleToUser(Request $request, int $id) {
        $role = Role::findOrFail($request->input('role_id'));

        $this->authorize('update', $role);

        $back = route('user.details', ['id' => $id]) . "#roles";

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
            return redirect($back)
                ->withErrors($validator, 'attachRole');
        }

        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return redirect($back)
                ->with('error', 'Die Rollen des Administrators können nicht geändert werden.');
        }

        if ($user->hasRole($role->name)) {
            return redirect($back)
                ->withErrors(["Der Benutzer hat die Rolle '$role->name' bereits."]);
        }

        $user->roles()->attach($role);
        $user->save();

        return redirect($back)
            ->with('success', 'Die Rolle wurde dem Benutzer zugeordnet.');
    }

    /**
     * Detach a role from a user
     * 
     * @param Request $request
     * @param int $id ID of the user
     * @return RedirectResponse
     */
    public function detachRoleFromUser(Request $request, int $id) {
        $role = Role::findOrFail($request->input('role_id'));

        $this->authorize('update', $role);

        $back = route('user.details', ['id' => $id]) . "#roles";

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
            return redirect($back)
                ->withErrors($validator, 'detachRole');
        }

        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return redirect($back)
                ->with('error', 'Die Rollen des Administrators können nicht geändert werden.');
        }

        if (!$user->hasRole($role->name)) {
            return redirect($back)
                ->withErrors(["Der Benutzer hat die Rolle '$role->name' nicht."]);
        }

        $user->roles()->detach($role);
        $user->save();

        return redirect($back)
            ->with('success', 'Die Rolle des Benutzers wurde entfernt.');
    }

    /**
     * Show details of a role
     * 
     * @param string $name Name of the role
     * @return View
     */
    public function details(string $name) {
        $role = Role::where('name', $name)->firstOrFail();

        $availablePermissions = [];

        foreach (Permission::all() as $permission) {
            if (!$role->hasPermission($permission->name)) {
                $availablePermissions[] = $permission;
            }
        }

        return view('role.details', [
            'role' => $role,
            'availablePermissions' => $availablePermissions
        ]);
    }

    /**
     * Show form for role creation
     * 
     * @return RedirectResponse
     */
    public function create() {
        return view('role.create');
    }

    /**
     * Save a new role
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) {
        $rules = [
            'name' => 'required|min:5|max:255|alpha_dash|unique:App\Role',
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

        return redirect(route('role.details', ['name' => $role->name]))
            ->with('success', "Die Rolle '$role->name' wurde gespeichert.");
    }

    /**
     * Show a list of all roles
     * 
     * @return View
     */
    public function list() {
        return view('role.list', ['roles' => Role::all()]);
    }

    /**
     * Delete a role from the database
     * 
     * @param int $id ID of the role
     * @return RedirectResponse
     */
    public function delete(int $id) {
        $role = Role::findOrFail($id);

        if ($role->name == Role::administratorRoleName()) {
            return redirect(route('role.details', ['name' => $role->name]))
                ->with('error', 'Die Administratorrolle kann nicht gelöscht werden.');
        }

        $role->delete();

        return redirect(route('role.list'))
            ->with('success', "Die Rolle wurde gelöscht.");
    }

    /**
     * Update a role
     * 
     * @param Request $request
     * @param string $name Name of the role
     * @return RedirectResponse
     */
    public function update(Request $request, string $name) {
        $role = Role::where('name', $name)->firstOrFail();

        $this->authorize('update', $role);

        if ($role->isAdmin()) {
            return redirect(route('role.details', ['name' => $name]))
                ->with('error', 'Die Administratorrolle kann nicht geändert werden.');
        }

        $rules = [
            'name' => [
                'required',
                'min:5',
                'max:255',
                'alpha_dash',
                Rule::unique('roles')->ignore($role)
            ],
            'description' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('role.details', ['name' => $name]))
                ->withErrors($validator);
        }

        $role->name = $request->input('name');
        $role->description = $request->input('description');

        $role->save();

        return redirect(route('role.details', ['name' => $role->name]))
            ->with('success', "Die Rolle wurde aktualisiert.");
    }
}
