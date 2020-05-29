<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        return view('user.details', ['user' => $user, 'availableRoles' => Role::all()]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name_first' => 'required',
            'name_last' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('user.details', ['id' => $id]))
                ->withErrors($validator, 'userUpdate');
        }

        $user = User::findOrFail($id);

        $user->name_first = $request->input('name_first');
        $user->name_last = $request->input('name_last');
        $user->email = $request->input('email');

        $user->save();

        return redirect(route('user.details', ['id' => $id]))
            ->with('success', 'Der Benutzer wurde aktualisiert.');
    }
}
