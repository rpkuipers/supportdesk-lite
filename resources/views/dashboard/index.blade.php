@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>
<div class="grid">
    <div class="card"><h2>{{ $openCount }}</h2><p>Open tickets</p></div>
    <div class="card"><h2>{{ $overdueCount }}</h2><p>Over tijd</p></div>
    <div class="card"><h2>{{ $resolvedCount }}</h2><p>Opgelost</p></div>
</div>

<div class="card">
    <h2>Recente tickets</h2>
    <p><a class="btn" href="{{ route('tickets.create') }}">Nieuw ticket</a></p>
    <table>
        <thead><tr><th>Referentie</th><th>Titel</th><th>Klant</th><th>Status</th><th>Prioriteit</th><th>Toegewezen aan</th><th>Aangemaakt door</th><th>Oppakken</th></tr></thead>
        <tbody>
        @foreach($recentTickets as $ticket)
            <tr>
                <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->reference }}</a></td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->customer->name }}</td>
                <td>{{ $ticket->status->label() }}</td>
                <td>{{ $ticket->priority->label() }}</td>
                <td>{{ $ticket->assignee?->name ?? 'Niet toegewezen' }}</td>
                <td>{{ $ticket->creator?->name ?? 'Onbekend' }}</td>
                <td>
                    @if($ticket->assigned_to === null)
                        <form method="POST" action="{{ route('tickets.selfassign', $ticket) }}">
                            @csrf
                            <button type="submit">
                                Pak ticket op
                            </button>
                        </form>
                    @else
                        
                        <!--{{ $ticket->assignee?->name ?? 'Toegewezen' }} -->
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
