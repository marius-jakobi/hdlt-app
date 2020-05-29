@extends('layouts.app')

@section('content')
<h1>Rollendetails (ID: {{ $role->id }})</h1>
<ul class="nav nav-tabs mb-3" id="nav-tab">
    <li class="nav-item">
        <a href="#data" class="nav-link active" id="data-tab" data-toggle="tab">Daten</a>
    </li>
    <li class="nav-item">
        <a href="#rights" class="nav-link" id="rights-tab" data-toggle="tab">Rechte</a>
    </li>
    <li class="nav-item">
        <a href="#actions" class="nav-link" id="actions-tab" data-toggle="tab">Aktionen</a>
    </li>
</ul>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="data">
        <h2>Daten</h2>
        <p>Rollenname: {{ $role->name }}</p>
        <p>Beschreibung: {{ $role->description }}</p>
    </div>
    <div class="tab-pane fade" id="rights">
        <h2>Rechte</h2>
        @if (count($availablePermissions) > 0)
            <form action="{{ route('permission.attach', ['name' => $role->name]) }}" method="post" class="form-inline">
                @csrf
                <select name="permission_id" class="form-control mr-2">
                    @foreach($availablePermissions as $availablePermission)
                        <option value="{{ $availablePermission->id }}">{{ $availablePermission->name }} - {{ $availablePermission->description }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Recht hinzufügen</button>
            </form>
            @if ($errors->attachPermission->any())
                @foreach($errors->attachPermission->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
        @else
            <div class="alert alert-info">Dieser Rolle können keine weiteren Rechte zugeordnet werden.</div>
        @endif
        @if ($role->permissions->count() == 0)
            <div class="alert alert-info mt-3">Diese Rolle verfügt über keine Rechte.</div>
        @else
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Beschreibung</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role->permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->description }}</td>
                        <td>
                            <form action="{{ route('permission.detach', ['name' => $role->name]) }}" method="post">
                                @method('delete')
                                @csrf
                                <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Recht wirklich entfernen?');">Recht entfernen</button>
                            </form>
                            @if ($errors->detachPermission->any())
                                @foreach($errors->detachPermission->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="tab-pane fade" id="actions">
        <h2>Aktionen</h2>
        <h3>Rolle löschen</h3>
        <p>Mit dieser Aktion wird die Rolle dauerhaft und unwiderruflich gelöscht.</p>
        <form action="{{ route('role.delete', ['id' => $role->id]) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Soll diese Rolle wirklich dauerhaft gelöscht werden?');">Rolle löschen</button>
        </form>
    </div>
</div>
@endsection