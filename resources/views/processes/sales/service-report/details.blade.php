@extends('layouts.app')

@section('content')
    <h1>Service-Bericht</h1>
    <p>ID: {{ $report->id }}</p>
    <p>Einsatzzweck: {{ $report->intent }}</p>
    <p>Text: {{ $report->text }}</p>
@endsection