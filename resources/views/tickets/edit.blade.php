@extends('layouts.app')

@section('content')
<h1>Ticket bewerken</h1>
<form method="post" action="{{ route('tickets.update', $ticket) }}" class="card">
    @csrf
    @method('PUT')
    @include('tickets._form')
    <label>Nieuwe notitie</label>
    <textarea name="note" rows="4"></textarea>
    <label>Auteur</label>
    <input name="author_name" value="Support">
    <label><input type="checkbox" name="is_internal" value="1" style="width:auto"> Interne notitie</label>
    <p><button>Opslaan</button></p>
</form>
@endsection
