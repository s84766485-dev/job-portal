<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shortlist') · Job Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { display: ['"Bricolage Grotesque"', 'sans-serif'], sans: ['"Source Sans 3"', 'sans-serif'] },
                colors: { ink: '#0F1B2D', paper: '#F4F6F8', teal: { DEFAULT: '#0E7C86', dark: '#0A5E66' }, amber: { DEFAULT: '#E9A23B' } },
            } },
        };
    </script>
    <style>
        :focus-visible { outline: 2px solid #0E7C86; outline-offset: 2px; }
        .field { width: 100%; border: 1px solid #cbd5e1; border-radius: .5rem; padding: .55rem .75rem; background: #fff; }
        .field:focus { border-color: #0E7C86; outline: 2px solid #0E7C8633; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; border-radius: .5rem; padding: .55rem 1rem; font-weight: 600; transition: background .15s; cursor: pointer; }
        .btn-primary { background: #0E7C86; color: #fff; } .btn-primary:hover { background: #0A5E66; }
        .btn-ghost { border: 1px solid #cbd5e1; background: #fff; color: #0F1B2D; } .btn-ghost:hover { background: #f1f5f9; }
        .btn-danger { color: #be123c; } .btn-danger:hover { background: #fff1f2; }
    </style>
</head>
<body class="bg-paper text-slate-800 font-sans antialiased min-h-screen flex flex-col">

<header class="bg-ink text-white">
    <nav class="max-w-6xl mx-auto px-4 h-16 flex items-center gap-6">
        <a href="{{ route('home') }}" class="font-display text-xl font-bold tracking-tight">Shortlist</a>
        <a href="{{ route('jobs.index') }}" class="text-slate-300 hover:text-white">Browse jobs</a>

        <div class="ml-auto flex items-center gap-4">
        @auth
            @php $u = auth()->user(); @endphp
            @if ($u->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white">Admin</a>
            @elseif ($u->isEmployer())
                <a href="{{ route('employer.dashboard') }}" class="text-slate-300 hover:text-white">Dashboard</a>
                <a href="{{ route('employer.jobs.index') }}" class="text-slate-300 hover:text-white">My jobs</a>
            @else
                <a href="{{ route('candidate.applications') }}" class="text-slate-300 hover:text-white">My applications</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn btn-ghost !py-1.5 !text-sm">Sign out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-slate-300 hover:text-white">Sign in</a>
            <a href="{{ route('register') }}" class="btn btn-primary !py-1.5">Create account</a>
        @endauth
        </div>
    </nav>
</header>

<main class="flex-1 w-full max-w-6xl mx-auto px-4 py-8">
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3" role="status">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3" role="alert">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<footer class="border-t border-slate-200 py-6 text-center text-sm text-slate-500">
    © {{ date('Y') }} Shortlist Job Portal
</footer>
</body>
</html>
