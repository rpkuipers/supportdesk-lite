@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 520px; margin: 40px auto;">
        <h1>Inloggen</h1>
        <p>Log in om je tickets te beheren.</p>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">E-mailadres</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

            <label for="password">Wachtwoord</label>
            <input
                id="password"
                type="password"
                name="password"
                required
            >

            <label style="display: flex; gap: 8px; align-items: center; margin-top: 12px;">
                <input type="checkbox" name="remember" value="1">
                Ingelogd blijven
            </label>

            <div style="margin-top: 20px;">
                <button type="submit">Inloggen</button>
            </div>
        </form>

        <p style="margin-top: 20px;">
            Nog geen account?
            <a href="{{ route('register') }}">Maak er een aan</a>.
        </p>
    </div>
@endsection