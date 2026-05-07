@extends('layouts.app')

@section('content')
<h1>{{ $onlyMine ? 'Mijn tickets' : 'Alle tickets' }}</h1>
<p><a class="btn" href="{{ route('tickets.create') }}">Nieuw ticket</a></p>

<div class="card">
    <form method="GET" action="{{ $onlyMine ? route('tickets.my') : route('tickets.index') }}">
        <div>
            <label>Status</label>
            <select name="status">
                <option value="">Alle statussen</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Prioriteit</label>
            <select name="priority">
                <option value="">Alle prioriteiten</option>
                @foreach($priorities as $priority)
                    <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>{{ $priority->label() }}</option>
                @endforeach
            </select>
        </div>
        <div style="align-self:end"><button>Filter</button></div>
        <div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Zoeken op titel of referentie"
                >

                <label>
                    <input
                        type="checkbox"
                        name="include_description"
                        value="1"
                        @checked(request()->boolean('include_description'))
                    >
                Zoek ook in descriptie
                </label>
        </div>
    </form>
</div>

<table>
    <thead><tr><th>Ref</th><th>Titel</th><th>Klant</th><th>Categorie</th><th>Status</th><th>Prioriteit</th><th>Toegewezen aan</th><th>Aangemaakt door</th><th>SLA</th></tr></thead>
    <tbody>
    @foreach($tickets as $ticket)
        <tr>
            <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->reference }}</a></td>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->customer->name }}</td>
            <td>{{ $ticket->category->name }}</td>
            <td>{{ $ticket->status->label() }}</td>
            <td>{{ $ticket->priority->label() }}</td>
            <td>{{ $ticket->assignee?->name ?? 'Niet toegewezen' }}</td>
            <td>{{ $ticket->creator?->name ?? 'Onbekend' }}</td>
            <td>@if($ticket->isOverdue())<span class="badge">Over tijd</span>@else{{ optional($ticket->due_at)->diffForHumans() }}@endif</td>
            
        </tr>
    @endforeach
    </tbody>
</table>

<div class="card">{{ $tickets->links() }}</div>
@endsection
