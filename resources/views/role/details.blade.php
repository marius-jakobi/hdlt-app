@extends('layouts.app')

@section('title', "Rolle")

@push('scripts')
<script src="{{ asset('js/tabs.js') }}" defer></script>
@endpush

@section('content')
<h1>Rolle "{{ $role->name }}"</h1>

@if ($role->isAdmin())
    <div class="alert bg-info">Dies ist die Administrator Rolle. Sie kann weder geändert noch gelöscht werden.</div>
@endif

<ul class="nav nav-tabs mb-3" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="data-tab" data-toggle="tab">Daten</a>
    </li>
    <li class="nav-item">
        <a href="#rights" class="nav-link" id="rights-tab" data-toggle="tab">Berechtigungen</a>
    </li>
    @if (!$role->isAdmin())
        <li class="nav-item">
            <a href="#actions" class="nav-link" id="actions-tab" data-toggle="tab">Aktionen</a>
        </li>
    @endif
</ul>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="data">
        <p>UID: {{ $role->id }}</p>
        @if ($role->isAdmin())
            <p>Name: {{ $role->name }}</p>
            <p>Beschreibung: {{ $role->description }}</p>
        @else
            <form action="{{ route('role.update', ['name' => $role->name]) }}" method="post">
                @method('put')
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}"/>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Beschreibung</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $role->description }}" />
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Speichern</button>
            </form>
        @endif
    </div>
    <div class="tab-pane fade" id="rights">
        @if (count($availablePermissions) > 0)
            <form action="{{ route('permission.attach', ['name' => $role->name]) }}" method="post" class="form-inline">
                @csrf
                <select name="permission_id" class="form-control mr-2">
                    @foreach($availablePermissions as $availablePermission)
                        <option value="{{ $availablePermission->id }}">{{ $availablePermission->name }} - {{ $availablePermission->description }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Berechtigung hinzufügen</button>
            </form>
            @if ($errors->attachPermission->any())
                @foreach($errors->attachPermission->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
        @else
            <div class="alert bg-info">Dieser Rolle können keine weiteren Berechtigungen zugeordnet werden.</div>
        @endif
        @if ($role->permissions->count() == 0)
            <div class="alert bg-info mt-3">Diese Rolle verfügt über keine Berechtigungen.</div>
        @else
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Beschreibung</th>
                        @if(!$role->isAdmin())
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($role->permissions as $permission)
                    <tr>
                        <td>
                            <a href="{{ route('permission.details', ['name' => $permission->name]) }}">{{ $permission->name }}</a>
                        </td>
                        <td>{{ $permission->description }}</td>
                        @if(!$role->isAdmin())
                            <td>
                                <form action="{{ route('permission.detach', ['name' => $role->name]) }}" method="post">
                                    <div class="text-right">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Berechtigung wirklich entfernen?');">Berechtigung entfernen</button>
                                        @if ($errors->detachPermission->any())
                                            @foreach($errors->detachPermission->all() as $error)
                                                <p class="text-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                </form>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @if (!$role->isAdmin())
        <div class="tab-pane fade" id="actions">
            <h3>Rolle löschen</h3>
            <p>Mit dieser Aktion wird die Rolle dauerhaft und unwiderruflich gelöscht.</p>
            <form action="{{ route('role.delete', ['id' => $role->id]) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-primary" onclick="return confirm('Soll diese Rolle wirklich dauerhaft gelöscht werden?');">Rolle löschen</button>
            </form>
        </div>
    @endif
</div>
@endsection