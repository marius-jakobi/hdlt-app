@extends('layouts.app')

@section('content')
    <h1>Auftragsbestätigung {{ $orderConfirmation->document_number }}</h1>
    <p>
        Kunde:
        <a href="{{ route('customer.details', ['customerId' => $orderConfirmation->salesProcess->customer->id]) }}">
            {{ $orderConfirmation->salesProcess->customer->description }}
        </a>
    </p>
    <p>
        Verkaufsvorgang:
        <a href="{{ route('process.sales.details', ['processNumber' => $orderConfirmation->salesProcess->process_number]) }}">
            {{ $orderConfirmation->salesProcess->process_number }}
        </a>
    </p>
    <h2>Service-Berichte</h2>
    @if ($orderConfirmation->serviceReports->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>erstellt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderConfirmation->serviceReports as $report)
                <tr>
                    <td>
                        <a href="{{ route('process.sales.service-report.details', ['reportId' => $report->id]) }}">
                        {{ $report->getId() }}
                        </a>
                    </td>
                    <td>{{ $report->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert bg-info">Für diese Auftragsbestätigung existieren keine Service-Berichte.</div>
    @endif
@endsection