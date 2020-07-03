@extends('layouts.app')

@section('content')
    <h1>Verkaufsvorgang {{ $process->process_number }}</h1>
    <p>
        Kunde:
        <a href="{{ route('customer.details', ['customerId' => $process->customer->id]) }}">
            {{ $process->customer->description }}
        </a>
    </p>
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
                    <td>
                        <a href="{{ route('process.sales.order-confirmation.details', ['processNumber' => $process->process_number, 'documentNumber' => $orderConfirmation->document_number]) }}">
                            {{ $orderConfirmation->document_number }}
                        </a>
                    </td>
                    <td>{{ $orderConfirmation->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection