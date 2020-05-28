<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile() {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function list() {
        return view('user.list', ['users' => \App\User::orderBy('name', 'asc')->get()]);
    }

    public function details($id) {
        return view('user.details', ['user' => \App\User::findOrFail($id)]);
    }
}
