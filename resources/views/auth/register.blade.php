@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 520px; margin: 40px auto;">
        <h1>Account aanmaken</h1>
        <p>Maak een account aan om SupportDesk Lite te gebruiken.</p>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label for="name">Naam</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
            >

            <label for="email">E-mailadres</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            <label for="password">Wachtwoord</label>
            <input
                id="password"
                type="password"
                name="password"
                required
            >

            <label for="password_confirmation">Herhaal wachtwoord</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
            >

            <div style="margin-top: 20px;">
                <button type="submit">Registreren</button>
            </div>
        </form>

        <p style="margin-top: 20px;">
            Heb je al een account?
            <a href="{{ route('login') }}">Log hier in</a>.
        </p>
    </div>
@endsection