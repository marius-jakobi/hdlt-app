@extends('layouts.app')

@section('content')
    <h1>Verkaufsvorgang {{ $process->process_number }}</h1>
    <h2>Auftragsbestätigungen</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Belegnummer</th>
                <th>erstellt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($process->orderConfirmations as $orderConfirmation)
                <tr>
                    <td>{{ $orderConfirmation->document_number }}</td>
                    <td>{{ $orderConfirmation->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection