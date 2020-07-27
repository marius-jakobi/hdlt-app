@if ($reports->count() > 0)
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Bericht</th>
                <th>Einsatzzweck</th>
                <th>Verkaufsvorgang</th>
                <th>Auftragsbestätigung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>
                        <a href="{{ route('process.sales.service-report.details', ['reportId' => $report->id]) }}">
                            Bericht vom {{ $report->getLocalDate() }}
                        </a>
                    </td>
                    <td>{{ $report->intent }}</td>
                    <td>
                        <a href="{{ route('process.sales.details', ['processNumber' => $report->orderConfirmation->salesProcess->process_number]) }}">
                            {{ $report->orderConfirmation->salesProcess->process_number }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('process.sales.order-confirmation.details', ['documentNumber' => $report->orderConfirmation->document_number]) }}">
                            {{ $report->orderConfirmation->document_number }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert bg-info">Es wurden keine Service-Berichte gefunden.</div>
@endif