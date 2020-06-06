<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Show the profile of the current user
     * 
     * @return View
     */
    public function profile() {
        return view('user.profile', ['user' => Auth::user()]);
    }

    /**
     * Show a list with all users
     * 
     * @return View
     */
    public function list() {
        return view('user.list', ['users' => User::orderBy('name_last', 'asc')->get()]);
    }

    /**
     * Show details of a user
     * 
     * @param int $id ID of the user
     * @return View
     */
    public function details(int $id) {
        $user = User::findOrFail($id);

        $this->authorize('view', $user);
        
        $availableRoles = [];

        foreach (Role::all() as $role) {
            if (!$user->hasRole($role->name)) {
                $availableRoles[] = $role;
            }
        }

        return view('user.details', ['user' => $user, 'availableRoles' => $availableRoles]);
    }

    /**
     * Update a user
     * 
     * @param Request $request
     * @param int $id ID of the user
     * @return RedirectResponse
     */
    public function update(Request $request, int $id) {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        if ($user->isAdmin()) {
            return redirect(route('user.details', ['id' => $id]))
                ->with('error', 'Der Administrator kann nicht verändert werden.');
        }

        $validator = Validator::make($request->all(), [
            'name_first' => 'required',
            'name_last' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors($validator, 'userUpdate');
        }

        $user->name_first = $request->input('name_first');
        $user->name_last = $request->input('name_last');
        $user->email = $request->input('email');

        $user->save();

        return redirect(route('user.details', ['id' => $id]))
            ->with('success', 'Der Benutzer wurde aktualisiert.');
    }

    /**
     * Delete a user from database
     * 
     * @param int $id ID of the user
     * @return RedirectResponse
     */
    public function delete(int $id) {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        if ($user->isAdmin()) {
            return redirect(route('user.details', ['id' => $id]))
                ->with('error', "Der Administrator kann nicht gelöscht werden.");
        }
        
        $user->delete();

        return redirect(route('user.list'))
            ->with('success', 'Der Benutzer wurde dauerhaft gelöscht.');
    }

    /**
     * Update the password of a user
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request) {
        $rules = [
            'new_password' => 'required|min:8|max:128|same:new_password_confirmation',
        ];

        $messages = [
            'new_password.required' => 'Ein Passwort wird benötigt',
            'new_password.min' => 'Das Passwort muss mindestens 8 Zeichen enthalten',
            'new_password.max' => 'Das Passwort darf maximal 128 Zeichen enthalten',
            'new_password.same' => 'Die Passwörter stimmen nicht überein'
        ];

        $validator = Validator::make($request->input(), $rules, $messages, ['new_password' => 'Passwort']);

        if ($validator->fails()) {
            return redirect(route('profile') . "#change-password")
                ->withErrors($validator);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            // Password is incorrect
            return redirect(route('profile') . "#change-password")
                ->with('error', 'Das angegebene Passwort ist nicht korrekt.');
        }

        $user->password = Hash::make($request->input('new_password'));

        $user->save();

        return redirect(route('profile'))
            ->with('success', "Das Passwort wurde erfolgreich geändert.");
    }
}
