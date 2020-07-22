@extends('layouts.app')

@push('scripts')
<script>
    setInterval(() => {
        document.getElementById('time').innerHTML = new Date().toLocaleString();
    }, 1000);
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ $greeting }}</h1>
        <p id="time"></p>
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
