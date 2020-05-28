@extends('layouts.app')

@section('content')
<h1>Benutzerprofil</h1>
<h2>Rollen</h2>
<ul>
    @if($user->roles->count() == 0)
        <li>Es sind keine Rollen zugeordnet</li>
    @endif
    @foreach ($user->roles as $role)
        <li>
            {{ $role->name }} - {{ $role->description }}
            <ul>
                @if($role->permissions->count() == 0)
                    <li>Diese Rolle hat keine Rechte</li>
                @endif
                @foreach($role->permissions as $permission)
                    <li>{{ $permission->description }}</li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
@endsection