<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pengajuan Nomor BRS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@600;700&family=IBM+Plex+Mono:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #F3F4F1; color: #1C2B45; }
        .font-serif-brs { font-family: 'Source Serif 4', serif; }
        .font-mono-brs { font-family: 'IBM Plex Mono', monospace; }
        .navy { color: #1C2B45; }
        .bg-navy { background-color: #1C2B45; }
        .bg-navy-deep { background-color: #111B2E; }
        .brass { color: #9C6F35; }
        .bg-brass-soft { background-color: #F3EADA; }
        .border-hairline { border-color: #DCDFE3; }
    </style>
</head>
<body class="min-h-screen">
        <header class="bg-navy text-white">
            <div class="max-w-3xl mx-auto px-6 py-5 flex items-center justify-between">
                <div>
                    <p class="text-xs tracking-widest uppercase text-slate-300">BPS Kota Lubuklinggau</p>
                    <h1 class="font-serif-brs text-xl font-semibold">Pengajuan nomor berita resmi statistik</h1>
                </div>
                <a href="{{ route('login') }}"
                class="flex items-center gap-1.5 rounded-full border border-white/15 px-3 py-1.5 text-xs text-slate-300 hover:text-brass hover:border-brass/40 transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3.5 w-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Masuk admin
                </a>
            </div>
        </header>

    <main class="max-w-3xl mx-auto px-6 py-8">
        @if (session('nomorBaru'))
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-4 text-sm" style="border-left: 3px solid #3F7D53;">
                <p class="font-medium mb-1">BRS berhasil diajukan. Nomor BRS kamu:</p>
                <p class="font-mono-brs text-lg font-semibold brass">{{ session('nomorBaru') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded border border-hairline bg-white px-4 py-3 text-sm" style="border-left: 3px solid #A23B3B;">
                <p class="font-medium mb-1">Ada isian yang perlu diperbaiki:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach (array_unique($errors->all()) as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>