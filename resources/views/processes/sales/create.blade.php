@extends('layouts.app')

@section('content')
    <h1>Verkaufsvorgang anlegen</h1>
    <p>Kunde: <a href="#">{{ $customer->description }}</a></p>
    <form action="" method="post" novalidate>
        @csrf
        <div class="form-group">
            <label>Vorgangsnummer</label>
            <input type="text" name="process_number" class="form-control @error('process_number') is-invalid @enderror" value="{{ old('process_number') }}" minlength="6" maxlength="6" required />
        </div>
        @error('process_number')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <button type="submit" class="btn btn-primary">Verkaufsvorgang anlegen</button>
    </form>
@endsection