@extends('layouts.app')

@section('content')
<h1>Nieuw ticket</h1>
<form method="post" action="{{ route('tickets.store') }}" class="card">
    @csrf
    @include('tickets._form')
    <p><button>Aanmaken</button></p>
</form>
@endsection
