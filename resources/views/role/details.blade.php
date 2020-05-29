@extends('layouts.app')

@section('content')
<h1>Rollendetails</h1>
<p>UID: {{ $role->id }}</p>
<p>Rollenname: {{ $role->name }}</p>
<p>Beschreibung: {{ $role->description }}</p>
<h2>Rechte</h2>
<ul>
    @foreach ($role->permissions as $permission)
        <li>{{ $permission->description }} ({{ $permission->name }})</li>
    @endforeach
</ul>
@endsection