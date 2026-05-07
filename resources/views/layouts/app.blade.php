<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f6f7fb; color: #172033; }
        header { background: #172033; color: white; padding: 1rem 2rem; }
        nav a { color: white; margin-right: 1rem; text-decoration: none; }
        main { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 14px; padding: 1.25rem; box-shadow: 0 10px 25px rgba(23,32,51,.08); margin-bottom: 1rem; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 14px; overflow: hidden; }
        th, td { padding: .8rem; border-bottom: 1px solid #e6e8ef; text-align: left; vertical-align: top; }
        input, select, textarea { width: 100%; padding: .65rem; border: 1px solid #cfd5e3; border-radius: 8px; box-sizing: border-box; }
        label { font-weight: 650; display: block; margin-top: .8rem; }
        button, .btn { display: inline-block; background: #2454d6; color: white; border: 0; padding: .65rem .9rem; border-radius: 9px; text-decoration: none; cursor: pointer; }
        .btn.secondary { background: #4d5b75; }
        .btn.danger { background: #c33030; }
        .muted { color: #64708a; }
        .flash { padding: .8rem 1rem; border-radius: 10px; margin-bottom: 1rem; }
        .success { background: #e5f8ed; color: #145c2c; }
        .error { background: #ffe8e8; color: #8b1d1d; }
        .badge { display: inline-block; padding: .2rem .45rem; border-radius: 999px; background: #edf1ff; }
    </style>
</head>
<body>
<header>
    <strong>SupportDesk Lite</strong>
    <nav>
    @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('tickets.index') }}">Tickets</a>
        <a href="{{ route('tickets.my') }}">Mijn Tickets</a>
        <a href="{{ route('categories.index') }}">Categorieën</a>

        <span style="margin-left: 20px;">
            Ingelogd als {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Uitloggen</button>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}">Inloggen</a>
        <a href="{{ route('register') }}">Registreren</a>
    @endguest
</nav>
</header>
<main>
    @if(session('success')) <div class="flash success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="flash error">{{ session('error') }}</div> @endif
    @if($errors->any())
        <div class="flash error">
            <strong>Controleer deze velden:</strong>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    @yield('content')
</main>
</body>
</html>
