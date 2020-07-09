<table class="table">
    <thead>
        <tr>
            <th>Bericht</th>
            <th>Einsatzzweck</th>
            <th>Text</th>
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
                <td>{{ $report->text }}</td>
            </tr>
        @endforeach
    </tbody>
</table>