@extends('layouts.app')

@section('content')
<h1>Benutzerprofil</h1>
<p>Name: {{ $user->isAdmin() ? "Administrator" : "$user->name_first, $user->name_last" }}</p>
<p>E-Mail: {{ $user->email }}</p>
@endsection