@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Hallo, {{ Auth::user()->name }}!</h1>
    </div>
</div>
@endsection
