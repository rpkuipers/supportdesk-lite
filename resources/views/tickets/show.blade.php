@extends('layouts.app')

@section('content')
<h1>{{ $ticket->reference }}: {{ $ticket->title }}</h1>
<div class="card">
    <p><strong>Klant:</strong> {{ $ticket->customer->name }} / {{ $ticket->customer->email }}</p>
    <p><strong>Categorie:</strong> {{ $ticket->category->name }}</p>
    <p><strong>Status:</strong> {{ $ticket->status->label() }}</p>
    <p><strong>Prioriteit:</strong> {{ $ticket->priority->label() }}</p>
    <p><strong>Toegewezen aan:</strong>{{ $ticket->assignee?->name ?? 'Niet toegewezen' }}</p>
    <p><strong>Aangemaakt door:</strong>{{ $ticket->creator?->name ?? 'Onbekend' }}</p>
    <p><strong>Deadline:</strong> {{ optional($ticket->due_at)->format('d-m-Y H:i') }}</p>
    <p>{{ $ticket->description }}</p>
    <p><a class="btn secondary" href="{{ route('tickets.edit', $ticket) }}">Bewerken</a></p>
</div>

<div class="card">
    <h2>Acties</h2>
    @if(!$ticket->status->isClosed())
        <form method="post" action="{{ route('tickets.resolve', $ticket) }}">
            @csrf
            <label>Oplossingsnotitie</label>
            <textarea name="resolution_note" rows="3">Ticket opgelost.</textarea>
            <p><button>Markeer opgelost</button></p>
        </form>
    @else
        <form method="post" action="{{ route('tickets.reopen', $ticket) }}">
            @csrf
            <button>Heropen ticket</button>
        </form>
    @endif
</div>

<div class="card">
    <h2>Notities</h2>
    @foreach($ticket->notes as $note)
        <article class="card">
            <strong>{{ $note->user?->name ?? $note->author_name ?? 'Onbekend' }}</strong>
            @if($note->is_internal)<span class="badge">intern</span>@endif
            <p>{{ $note->body }}</p>
            <p class="muted">{{ $note->created_at->diffForHumans() }}</p>
        </article>
    @endforeach
    <form method="post" action="{{ route('tickets.addNote', $ticket) }}">
        @csrf
        <textarea name="new_note" rows="3" placeholder="Voeg de notitie toe."></textarea>
        <label><input type="checkbox" name="is_internal" value="1" style="width:auto"> Interne notitie</label>
        <button>Voeg notitie toe</button>
    </form>
</div>

<div class="card">
    <h2>Tickethistorie</h2>
    @foreach($ticket->statusHistories as $history)
        <article class="card">
            <p>Oude status: {{$history->old_status->label() }}</p>
            <p>nieuwe status: {{$history->new_status->label() }}</p>
            <p>Door: {{$history->user->name}} op {{$history->created_at}}
        </article>
    @endforeach
</div>
@endsection
