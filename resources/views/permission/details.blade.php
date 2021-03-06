@extends('layouts.app')

@section('title', "Berechtigung $permission->name")

@push('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endpush

@section('content')
<h1>Berechtigung "{{ $permission->name }}"</h1>
<ul class="nav nav-tabs mb-3" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="data-tab" data-toggle="tab">Daten</a>
    </li>
    <li class="nav-item">
        <a href="#roles" class="nav-link" id="role-tab" data-toggle="tab">Rollen</a>
    </li>
    <li class="nav-item">
        <a href="#actions" class="nav-link" id="actions-tab" data-toggle="tab">Aktionen</a>
    </li>
</ul>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="data">
        <p>UID: {{ $permission->id }}</p>
        <form action="{{ route('permission.update', ['id' => $permission->id]) }}" method="post">
            @method('put')
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $permission->name }}"/>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Beschreibung</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $permission->description }}" />
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
    <div class="tab-pane fade" id="roles">
        <p>Diese Berechtigung ist folgenden Rollen zugeordnet:</p>
        <ul>
            @foreach($permission->roles as $role)
                <li>
                    <a href="{{ route('role.details', ['name' => $role->name]) }}">{{ $role->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="tab-pane fade" id="actions">
        <h3>Berechtigung löschen</h3>
        <p>Mit dieser Aktion wird die Berechtigung dauerhaft und unwiderruflich gelöscht.</p>
        <form action="{{ route('permission.delete', ['id' => $permission->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Soll diese Berechtigung wirklich dauerhaft gelöscht werden?');">Berechtigung löschen</button>
        </form>
    </div>
</div>
@endsection