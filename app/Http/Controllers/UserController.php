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

        return view('user.details', ['user' => $user, 'availableRoles' => $availableRoles]);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

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

    public function delete($id) {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return redirect(route('user.details', ['id' => $id]))
                ->with('error', "Der Administrator kann nicht gelöscht werden.");
        }
        
        $user->delete();

        return redirect(route('user.list'))
            ->with('success', 'Der Benutzer wurde dauerhaft gelöscht.');
    }

    public function updatePassword(Request $request) {
        $rules = [
            'new_password' => 'required|min:8|max:128|same:new_password_confirmation',
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return redirect(route('profile') . "#change-password")
                ->withErrors($validator);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->input('password'), $user->password)) {
            // Password is incorrect
            return redirect(route('profile'))
                ->with('error', 'Das angegebene Passwort ist nicht korrekt.');
        }

        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect(route('profile'))
            ->with('success', "Das Passwort wurde erfolgreich geändert.");
    }
}
