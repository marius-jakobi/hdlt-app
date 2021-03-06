@extends('layouts.app')

@section('title', "Verkaufsvorgang $process->process_number")

@section('content')
    <h1>Verkaufsvorgang {{ $process->process_number }}</h1>
    @if($process->isLegacy())
        <div class="alert bg-warning">Warnung: Dieser Vorgang beinhaltet alle Service-Arbeiten aus dem alten Herbst-Tool.</div>
    @endif
    <p>
        Kunde:
        <a href="{{ route('customer.details', ['customerId' => $process->customer->id]) }}">
            {{ $process->customer->description }}
        </a>
    </p>
    <h2>Auftragsbestätigungen</h2>
    @can('create-order-confirmation', App\Models\OrderConfirmation::class)
        <a href="{{ route('process.sales.order-confirmation.create', ['processNumber' => $process->process_number]) }}" class="btn btn-primary mb-3">Auftragsbestätigung erstellen</a>
    @endcan
    <table class="table">
        <thead>
            <tr>
                <th>Belegnummer</th>
                <th>Service-Berichte</th>
                <th>erstellt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderConfirmations as $orderConfirmation)
                <tr>
                    <td>
                        <a href="{{ route('process.sales.order-confirmation.details', ['documentNumber' => $orderConfirmation->document_number]) }}">
                            {{ $orderConfirmation->document_number }}
                        </a>
                    </td>
                    <td>{{ $orderConfirmation->serviceReports->count() }}</td>
                    <td>{{ $orderConfirmation->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orderConfirmations->links() }}
@endsection