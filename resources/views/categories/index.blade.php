@extends('layouts.app')

@section('content')
<h1>Categorieën</h1>
<p><a class="btn" href="{{ route('categories.create') }}">Nieuwe categorie</a></p>
<table>
    <thead><tr><th>Naam</th><th>Omschrijving</th><th>Tickets</th><th>Acties</th></tr></thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td>{{ $category->tickets_count }}</td>
            <td><a href="{{ route('categories.edit', $category) }}">Bewerken</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
