@extends('layouts.app')

@section('content')
<h1>Rechte</h1>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Beschreibung</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($permissions as $permission)
        <tr>
            <td>
                <a href="{{ route('permission.details', ['name' => $permission->name]) }}">{{ $permission->name }}</a>
            </td>
            <td>{{ $permission->description }}</td>
            <td>
                {{-- <form action="{{ route('permission.delete', ['id' => $permission->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Recht wirklich löschen?');">Recht löschen</button>
                </form> --}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection