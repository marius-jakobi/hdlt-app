@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ $greeting }}</h1>
    </div>
</div>
@can('view-search-results', App\Models\User::class)
    <div class="row">
        <div class="col-12">
            <form action="{{ route('search.result') }}" method="post" class="form-inline">
                @csrf
                <input type="text" name="q" class="form-control" placeholder="Kunde / Lieferadresse">
                <button type="submit" class="btn btn-primary ml-2">Suchen</button>
            </form>
        </div>
    </div>
@endcan
@endsection
