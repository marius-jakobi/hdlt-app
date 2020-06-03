<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $time = date('G');
        $greeting = "Guten Morgen";
        $user = Auth::user();

        if ($time >= 12 && $time < 18) $greeting = "Guten Tag";
        if ($time >= 18) $greeting = "Guten Abend";

        return view('dashboard', ['greeting' => $greeting . ', ' . ($user->isAdmin() ? "Administrator!" : $user->shortName())]);
    }
}
