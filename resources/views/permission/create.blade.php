@extends('layouts.app')

@section('content')
<h1>Recht erstellen</h1>
<form action="{{ route('permission.create') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus/>
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label>Beschreibung</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  />
        @error('description')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Speichern</button>
</form>
@endsection