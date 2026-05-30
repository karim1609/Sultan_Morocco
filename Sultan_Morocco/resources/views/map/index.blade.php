<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotel Map — Sultan Morocco</title>
    <x-theme-init />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet" />

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Marker Cluster --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Reset & base ────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; }

        /* ── Map wrapper ─────────────────────────────────────── */
        #map-wrap {
            position: fixed;
            inset: 0;
            top: 64px; /* nav height */
            z-index: 0;
        }
        #map { width: 100%; height: 100%; }

        /* ── Leaflet popup overrides ─────────────────────────── */
        .leaflet-popup-content-wrapper {
            border-radius: 16px !important;
            padding: 0 !important;
            overflow: hidden !important;
            box-shadow: 0 24px 56px rgba(0,0,0,0.22), 0 4px 16px rgba(0,0,0,0.1) !important;
            border: 1px solid rgba(0,0,0,0.07) !important;
        }
        .leaflet-popup-content {
            margin: 0 !important;
            width: 270px !important;
            line-height: 1.5 !important;
        }
        .leaflet-popup-tip { background: #fff !important; }
        .leaflet-popup-close-button {
            top: 8px !important;
            right: 10px !important;
            color: rgba(255,255,255,0.9) !important;
            font-size: 20px !important;
            font-weight: 300 !important;
            z-index: 10 !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.4) !important;
        }
        .leaflet-popup-close-button:hover { color: #fff !important; }

        /* ── Cluster overrides ───────────────────────────────── */
        .marker-cluster-small,
        .marker-cluster-medium,
        .marker-cluster-large {
            background: rgba(0, 38, 26, 0.18) !important;
        }
        .marker-cluster-small div,
        .marker-cluster-medium div,
        .marker-cluster-large div {
            background: #00261a !important;
            color: #fff !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 700 !important;
            font-size: 12px !important;
        }

        /* ── Price marker ────────────────────────────────────── */
        .pm-wrap { position: relative; cursor: pointer; }
        .pm {
            background: #00261a;
            color: #fff;
            padding: 5px 9px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 3px 10px rgba(0,0,0,0.28);
            border: 2px solid #fff;
            transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                        background 0.18s,
                        box-shadow 0.18s;
            position: relative;
            user-select: none;
        }
        .pm::after {
            content: '';
            position: absolute;
            bottom: -7px;
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid transparent;
            border-top-color: #00261a;
        }
        .pm:hover, .pm.active {
            background: #785a06;
            transform: scale(1.14) translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
            z-index: 999 !important;
        }
        .pm.active::after { border-top-color: #785a06; }

        /* ── Rating dot on marker ────────────────────────────── */
        .pm-rating {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e8a030;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 8px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        /* ── Floating control panel ──────────────────────────── */
        #panel {
            position: fixed;
            top: 80px;
            left: 16px;
            z-index: 1000;
            width: 288px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 20px 50px rgba(0,0,0,0.18), 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.07);
            overflow: hidden;
            transform: translateX(0);
            transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
        }
        #panel.collapsed { transform: translateX(-310px); }
        .panel-header {
            background: linear-gradient(135deg, #00261a 0%, #0f3d2e 100%);
            padding: 16px 18px 14px;
            position: relative;
        }
        .panel-body { padding: 14px 16px; display: flex; flex-direction: column; gap: 10px; }

        /* ── Toggle panel button ─────────────────────────────── */
        #toggle-panel {
            position: fixed;
            top: 80px;
            left: 16px;
            z-index: 1001;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #00261a;
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
            transition: background 0.2s, transform 0.2s;
            opacity: 0;
            pointer-events: none;
        }
        #toggle-panel.show { opacity: 1; pointer-events: all; }
        #toggle-panel:hover { background: #0f3d2e; transform: scale(1.08); }

        /* ── Search box ──────────────────────────────────────── */
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f6f3ee;
            border: 1.5px solid #e5e2dd;
            border-radius: 20px;
            padding: 7px 12px;
            transition: border-color 0.2s;
        }
        .search-wrap:focus-within { border-color: #00261a; }
        .search-wrap input {
            border: none;
            background: transparent;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1c1c19;
            outline: none;
            width: 100%;
        }
        .search-wrap input::placeholder { color: #a0a09a; }

        /* ── Sort select ─────────────────────────────────────── */
        .sort-wrap {
            display: flex;
            align-items: center;
            gap: 7px;
            background: #f6f3ee;
            border: 1.5px solid #e5e2dd;
            border-radius: 20px;
            padding: 7px 12px;
        }
        .sort-wrap select {
            border: none;
            background: transparent;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1c1c19;
            outline: none;
            cursor: pointer;
            width: 100%;
        }

        /* ── Hotel list inside panel ─────────────────────────── */
        #hotel-list {
            max-height: 320px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
            scrollbar-width: thin;
            scrollbar-color: #c0c8c3 transparent;
        }
        #hotel-list::-webkit-scrollbar { width: 4px; }
        #hotel-list::-webkit-scrollbar-track { background: transparent; }
        #hotel-list::-webkit-scrollbar-thumb { background: #c0c8c3; border-radius: 4px; }

        .hotel-row {
            display: flex;
            gap: 9px;
            align-items: center;
            padding: 8px 10px;
            border-radius: 12px;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: background 0.15s, border-color 0.15s, transform 0.15s;
        }
        .hotel-row:hover { background: #f6f3ee; transform: translateX(2px); }
        .hotel-row.active { background: #f0ede9; border-color: #00261a; }
        .hotel-row-img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            background: #e5e2dd;
        }
        .hotel-row-info { flex: 1; min-width: 0; }
        .hotel-row-name {
            font-family: 'Noto Serif', serif;
            font-size: 12px;
            font-weight: 700;
            color: #1c1c19;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .hotel-row-loc {
            font-size: 10px;
            color: #717974;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }
        .hotel-row-price {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: #00261a;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* ── Load more btn ───────────────────────────────────── */
        .btn-load {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #00261a, #0f3d2e);
            color: #fff;
            border: none;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 4px 14px rgba(0,38,26,0.28);
        }
        .btn-load:hover:not(:disabled) { opacity: .88; transform: scale(0.98); }
        .btn-load:disabled { opacity: .5; cursor: not-allowed; }
        .btn-load.hidden { display: none; }

        /* ── Page info text ──────────────────────────────────── */
        .page-info {
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: #717974;
        }

        /* ── Legend bottom-right ─────────────────────────────── */
        #legend {
            position: fixed;
            bottom: 24px;
            right: 16px;
            z-index: 1000;
            background: #fff;
            border-radius: 14px;
            padding: 12px 16px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.14);
            border: 1px solid rgba(0,0,0,0.07);
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 150px;
        }
        .legend-title {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #717974;
            margin-bottom: 2px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: #1c1c19;
        }
        .legend-dot {
            width: 12px; height: 12px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        /* ── Loading overlay ─────────────────────────────────── */
        #loading-overlay {
            position: fixed;
            inset: 0;
            top: 64px;
            background: rgba(252,249,244,0.88);
            backdrop-filter: blur(6px);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            transition: opacity 0.4s ease;
        }
        #loading-overlay.hidden { opacity: 0; pointer-events: none; }
        .loader-ring {
            width: 52px; height: 52px;
            border: 4px solid #e5e2dd;
            border-top-color: #00261a;
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loader-text {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #717974;
            font-weight: 500;
        }

        /* ── Popup card ──────────────────────────────────────── */
        .popup-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }
        .popup-body { padding: 13px 14px 14px; }
        .popup-badges { display: flex; align-items: center; gap: 6px; margin-bottom: 7px; flex-wrap: wrap; }
        .popup-type {
            padding: 2px 9px;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }
        .popup-rating {
            padding: 3px 7px;
            border-radius: 7px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 800;
            color: #fff;
        }
        .popup-rating-label {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 600;
            color: #414944;
        }
        .popup-name {
            font-family: 'Noto Serif', serif;
            font-size: 14px;
            font-weight: 700;
            color: #1c1c19;
            line-height: 1.35;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .popup-loc {
            display: flex;
            align-items: center;
            gap: 3px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: #717974;
            margin-bottom: 4px;
        }
        .popup-addr {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            color: #a0a09a;
            font-style: italic;
            margin-bottom: 8px;
            min-height: 14px;
        }
        .popup-price {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #1c1c19;
            margin-bottom: 10px;
        }
        .popup-price span {
            font-size: 10px;
            font-weight: 400;
            color: #717974;
            margin-right: 3px;
        }
        .popup-actions {
            display: flex;
            gap: 7px;
        }
        .popup-btn {
            flex: 1;
            text-align: center;
            padding: 8px 6px;
            border-radius: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.18s, transform 0.18s;
            letter-spacing: .03em;
        }
        .popup-btn:hover { opacity: .85; transform: scale(0.97); }
        .popup-btn-outline {
            border: 1.5px solid #c0c8c3;
            color: #00261a;
            background: #fff;
        }
        .popup-btn-solid {
            background: linear-gradient(135deg, #00261a, #0f3d2e);
            color: #fff;
            border: none;
        }

        /* ── Zoom control positioning ────────────────────────── */
        .leaflet-control-zoom {
            border-radius: 14px !important;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.14) !important;
            border: 1px solid rgba(0,0,0,0.08) !important;
            margin-bottom: 24px !important;
            margin-right: 16px !important;
        }
        .leaflet-control-zoom-in,
        .leaflet-control-zoom-out {
            font-size: 18px !important;
            line-height: 32px !important;
            width: 36px !important;
            height: 36px !important;
            color: #1c1c19 !important;
        }
        .leaflet-control-zoom-in:hover,
        .leaflet-control-zoom-out:hover {
            background: #f0ede9 !important;
            color: #00261a !important;
        }

        /* ── Animate marker entrance ─────────────────────────── */
        @keyframes marker-pop {
            0%   { transform: scale(0) translateY(8px); opacity: 0; }
            70%  { transform: scale(1.15) translateY(-2px); }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .pm { animation: marker-pop 0.4s cubic-bezier(0.22,1,0.36,1) both; }

        /* Dark mode (class on html) */
        html.dark #panel {
            background: #1c1b18;
            border-color: rgba(255,255,255,0.08);
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
        }
        html.dark .panel-body { background: transparent; }
        html.dark .search-wrap,
        html.dark .sort-wrap {
            background: #2a2824;
            border-color: rgba(255,255,255,0.12);
        }
        html.dark .search-wrap input,
        html.dark .sort-wrap select { color: #f4f1eb; }
        html.dark .search-wrap input::placeholder { color: #8a8580; }
        html.dark .hotel-row:hover { background: #2f2d28; }
        html.dark .hotel-row.active { background: #35322c; border-color: #5eead4; }
        html.dark .hotel-row-name { color: #f4f1eb; }
        html.dark .hotel-row-loc { color: #a8a29e; }
        html.dark .hotel-row-price { color: #6ee7b7; }
        html.dark .page-info { color: #a8a29e; }
        html.dark #legend {
            background: #1c1b18;
            border-color: rgba(255,255,255,0.1);
        }
        html.dark .legend-title { color: #a8a29e; }
        html.dark .legend-item { color: #e7e5e4; }
        html.dark #loading-overlay {
            background: rgba(28, 27, 24, 0.92);
        }
        html.dark .loader-text { color: #a8a29e; }
        html.dark .loader-ring {
            border-color: #3f3e3a;
            border-top-color: #34d399;
        }
        html.dark .leaflet-popup-content-wrapper {
            background: #1c1b18 !important;
            border-color: rgba(255,255,255,0.12) !important;
        }
        html.dark .leaflet-popup-tip { background: #1c1b18 !important; }
        html.dark .popup-name { color: #f4f1eb; }
        html.dark .popup-rating-label { color: #d6d3d1; }
        html.dark .popup-loc { color: #a8a29e; }
        html.dark .popup-addr { color: #78716c; }
        html.dark .popup-price { color: #f4f1eb; }
        html.dark .popup-btn-outline {
            background: #2a2824 !important;
            border-color: rgba(255,255,255,0.15) !important;
            color: #6ee7b7 !important;
        }
        html.dark .leaflet-control-zoom-in,
        html.dark .leaflet-control-zoom-out {
            color: #e7e5e4 !important;
            background: #2a2824 !important;
        }
        html.dark .leaflet-control-zoom-in:hover,
        html.dark .leaflet-control-zoom-out:hover {
            background: #3f3e3a !important;
            color: #6ee7b7 !important;
        }
    </style>
</head>
<body class="font-body bg-background text-on-background transition-colors dark:bg-zinc-950 dark:text-zinc-100">

{{-- ═══════════════════════════ TOP NAV ════════════════════════════════ --}}
<nav class="fixed top-0 z-[2000] w-full border-b border-outline-variant/20 bg-surface/90 backdrop-blur-md dark:border-white/10 dark:bg-zinc-950/90" style="height:64px;">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4 md:px-8">

        <a href="{{ url('/') }}" class="font-headline text-2xl font-bold text-emerald-900 dark:text-emerald-400">Sultan</a>

        <div class="hidden items-center gap-8 md:flex">
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}">Home</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#destinations">Explore</a>
            <a class="border-b-2 border-amber-500 pb-1 font-body text-sm font-medium uppercase tracking-wider text-emerald-900 dark:text-emerald-400"
               href="{{ route('map.index') }}">Map</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#categories">Restaurants</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ route('hotels.index') }}">Hotels</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#experiences">Experiences</a>
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <x-theme-toggle class="!border-outline-variant/40 !bg-surface-container-lowest/90 !text-amber-800 hover:!bg-surface-container-high dark:!border-white/15 dark:!bg-white/10 dark:!text-amber-200 dark:hover:!bg-white/15" />
            @auth
                <span class="hidden max-w-[10rem] truncate text-xs font-medium text-stone-600 sm:inline dark:text-stone-400">
                    Hi, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('profile', Auth::id()) }}"
                   class="hidden rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high sm:inline dark:hover:bg-white/10">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-stone-600 transition hover:bg-surface-container-high dark:text-stone-400 dark:hover:bg-white/10">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high dark:hover:bg-white/10">
                    Log in
                </a>
                <a href="{{ route('signup') }}"
                   class="rounded-full bg-primary px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-on-primary transition hover:opacity-90">
                    Sign up
                </a>
            @endauth
            <a href="{{ auth()->check() ? route('profile', auth()->id()) : route('login') }}"
               class="rounded-full p-2 transition-colors hover:bg-surface-container-high dark:hover:bg-white/10">
                <span class="material-symbols-outlined text-emerald-900 dark:text-emerald-400">account_circle</span>
            </a>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════ LOADING OVERLAY ════════════════════════ --}}
<div id="loading-overlay">
    <div class="loader-ring"></div>
    <p class="loader-text" id="loading-text">Loading hotels on map…</p>
</div>

{{-- ═══════════════════════════ MAP ════════════════════════════════════ --}}
<div id="map-wrap">
    <div id="map"></div>
</div>

{{-- ═══════════════════════════ TOGGLE BUTTON ═════════════════════════ --}}
<button id="toggle-panel" title="Toggle panel">
    <span class="material-symbols-outlined" style="font-size:20px;">menu</span>
</button>

{{-- ═══════════════════════════ FLOATING PANEL ════════════════════════ --}}
<div id="panel">

    {{-- Header --}}
    <div class="panel-header">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-family:'Inter',sans-serif;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(255,255,255,0.6);margin-bottom:4px;">
                    🇲🇦 &nbsp;Curated listings
                </p>
                <h2 style="font-family:'Noto Serif',serif;font-size:18px;font-weight:700;color:#fff;line-height:1.2;">
                    Hotels in Morocco
                </h2>
                <p id="hotel-count" style="font-family:'Inter',sans-serif;font-size:12px;color:rgba(255,255,255,0.7);margin-top:3px;">
                    Loading…
                </p>
            </div>
            <button id="close-panel"
                    style="background:rgba(255,255,255,0.12);border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;transition:background 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.22)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.12)'"
                    title="Collapse panel">
                <span class="material-symbols-outlined" style="font-size:16px;">chevron_left</span>
            </button>
        </div>
    </div>

    {{-- Body --}}
    <div class="panel-body">

        {{-- Search --}}
        <div class="search-wrap">
            <span class="material-symbols-outlined" style="font-size:16px;color:#785a06;flex-shrink:0;">search</span>
            <input id="search-input" type="text" placeholder="Search hotels…" autocomplete="off" />
        </div>

        {{-- Sort --}}
        <div class="sort-wrap">
            <span class="material-symbols-outlined" style="font-size:16px;color:#785a06;flex-shrink:0;">sort</span>
            <select id="sort-sel">
                <option value="best_value">Best Value</option>
                <option value="popularity">Most Popular</option>
            </select>
        </div>

        {{-- Hotel list --}}
        <div id="hotel-list"></div>

        {{-- Load more --}}
        <button id="load-more" class="btn-load hidden">Load More Hotels</button>
        <p id="page-info" class="page-info"></p>

    </div>
</div>

{{-- ═══════════════════════════ LEGEND ═════════════════════════════════ --}}
<div id="legend">
    <p class="legend-title">Rating Scale</p>
    <div class="legend-item">
        <div class="legend-dot" style="background:#00261a;"></div>
        <span>9.0 + Exceptional</span>
    </div>
    <div class="legend-item">
        <div class="legend-dot" style="background:#0f5132;"></div>
        <span>8.5 + Fabulous</span>
    </div>
    <div class="legend-item">
        <div class="legend-dot" style="background:#0d6e6e;"></div>
        <span>8.0 + Very Good</span>
    </div>
    <div class="legend-item">
        <div class="legend-dot" style="background:#7a5200;"></div>
        <span>7.0 + Good</span>
    </div>
    <div class="legend-item">
        <div class="legend-dot" style="background:#555;"></div>
        <span>Below 7.0</span>
    </div>
</div>

{{-- ═══════════════════════════ SCRIPT ═════════════════════════════════ --}}
<script>
/* ═══════════════════════════════════════════════════════════════════════
   CONFIG
═══════════════════════════════════════════════════════════════════════ */
var API_BASE  = '/api/hotels';
var PAGE_SIZE = 30;

/* ═══════════════════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════════════════ */
var hotels     = [];
var markers    = {};       // key → Leaflet marker
var clusterGrp;
var sortBy     = 'best_value';
var offset     = 0;
var total      = 0;
var isBusy     = false;
var activeKey  = null;

/* Nominatim */
var addrCache = {};
var addrQueue = [];
var queueBusy = false;

/* ═══════════════════════════════════════════════════════════════════════
   DOM
═══════════════════════════════════════════════════════════════════════ */
var loadingOverlay = document.getElementById('loading-overlay');
var loadingText    = document.getElementById('loading-text');
var countEl        = document.getElementById('hotel-count');
var listEl         = document.getElementById('hotel-list');
var sortEl         = document.getElementById('sort-sel');
var searchInput    = document.getElementById('search-input');
var moreBtn        = document.getElementById('load-more');
var pageInfoEl     = document.getElementById('page-info');
var panel          = document.getElementById('panel');
var closeBtn       = document.getElementById('close-panel');
var toggleBtn      = document.getElementById('toggle-panel');

/* ═══════════════════════════════════════════════════════════════════════
   HELPERS
═══════════════════════════════════════════════════════════════════════ */
function esc(s) {
    return String(s)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function cityFromUrl(url) {
    try {
        var seg = url.split('/').pop().replace('.html','').split('-').pop();
        return seg.split('_')[0];
    } catch(e) { return 'Morocco'; }
}

function shortLocFromUrl(url) {
    try {
        var seg   = url.split('/').pop().replace('.html','').split('-').pop();
        var words = seg.split('_');
        return words.length > 1 ? words[0] + ', ' + words.slice(1).join(' ') : words[0];
    } catch(e) { return 'Morocco'; }
}

function ratingLabel(r) {
    if (r >= 9.5) return 'Exceptional';
    if (r >= 9.0) return 'Wonderful';
    if (r >= 8.5) return 'Fabulous';
    if (r >= 8.0) return 'Very Good';
    if (r >= 7.5) return 'Good';
    if (r >= 7.0) return 'Pleasant';
    return 'Reviewed';
}

function ratingBg(r) {
    if (r >= 9.0) return '#00261a';
    if (r >= 8.5) return '#0f5132';
    if (r >= 8.0) return '#0d6e6e';
    if (r >= 7.0) return '#7a5200';
    return '#555';
}

function typeBg(type) {
    var t = (type || '').toLowerCase().replace(/\s+/g,'');
    if (t.includes('hostel'))     return '#5b21b6';
    if (t.includes('resort'))     return '#92400e';
    if (t.includes('guest'))      return '#065f46';
    if (t.includes('smallhotel')) return '#1e3a8a';
    return '#00261a';
}

function priceMin(p) { return p ? '$' + p.minimum : '—'; }
function priceRange(p) { return p ? '$' + p.minimum + ' – $' + p.maximum : null; }

/* ═══════════════════════════════════════════════════════════════════════
   MAP INIT
═══════════════════════════════════════════════════════════════════════ */
var map = L.map('map', {
    center:    [31.0, -7.0],
    zoom:      6,
    zoomControl: true,
    attributionControl: true
});

/* CartoDB tiles — light / dark */
var lightTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
    subdomains:  'abcd',
    maxZoom:     20
});
var darkTiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
    subdomains:  'abcd',
    maxZoom:     20
});
var activeBase = document.documentElement.classList.contains('dark') ? darkTiles : lightTiles;
activeBase.addTo(map);

function syncMapBasemap() {
    var useDark = document.documentElement.classList.contains('dark');
    if (useDark) {
        if (map.hasLayer(lightTiles)) map.removeLayer(lightTiles);
        if (!map.hasLayer(darkTiles)) darkTiles.addTo(map);
    } else {
        if (map.hasLayer(darkTiles)) map.removeLayer(darkTiles);
        if (!map.hasLayer(lightTiles)) lightTiles.addTo(map);
    }
}
window.addEventListener('sultan-theme-change', syncMapBasemap);

/* Move zoom control to bottom-right */
map.zoomControl.setPosition('bottomright');

/* Cluster group */
clusterGrp = L.markerClusterGroup({
    maxClusterRadius: 50,
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true,
    iconCreateFunction: function(cluster) {
        var count = cluster.getChildCount();
        return L.divIcon({
            html: '<div style="background:#00261a;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Inter,sans-serif;font-size:12px;font-weight:700;border:2px solid #fff;box-shadow:0 3px 10px rgba(0,0,0,0.25);">' + count + '</div>',
            className: '',
            iconSize: L.point(36, 36),
            iconAnchor: [18, 18]
        });
    }
});
map.addLayer(clusterGrp);

/* ═══════════════════════════════════════════════════════════════════════
   POPUP HTML
═══════════════════════════════════════════════════════════════════════ */
function buildPopup(hotel) {
    var shortLoc  = shortLocFromUrl(hotel.url);
    var rating    = hotel.review_summary.rating;
    var price     = priceRange(hotel.price_ranges);
    var mapsUrl   = 'https://maps.google.com/?q=' + hotel.geo.latitude + ',' + hotel.geo.longitude;
    var addrId    = 'pop-addr-' + hotel.key.replace(/[^a-z0-9]/gi,'-');

    /* Queue Nominatim address */
    addrQueue.push({ lat: hotel.geo.latitude, lon: hotel.geo.longitude, elId: addrId });
    drainAddrQueue();

    return (
        (hotel.image
            ? '<img class="popup-img" src="' + esc(hotel.image) + '" alt="' + esc(hotel.name) + '" '
              + 'onerror="this.style.display=\'none\'" />'
            : '<div style="height:100px;background:linear-gradient(135deg,#f0ede9,#e5e2dd);display:flex;align-items:center;justify-content:center;font-size:2rem;">🏨</div>') +

        '<div class="popup-body">' +

            /* Badges */
            '<div class="popup-badges">' +
                '<span class="popup-type" style="background:' + typeBg(hotel.accommodation_type) + ';">'
                    + esc(hotel.accommodation_type || 'Hotel') + '</span>' +
                '<span class="popup-rating" style="background:' + ratingBg(rating) + ';">'
                    + rating.toFixed(1) + '</span>' +
                '<span class="popup-rating-label">' + ratingLabel(rating) + '</span>' +
            '</div>' +

            /* Name */
            '<p class="popup-name">' + esc(hotel.name) + '</p>' +

            /* Location */
            '<p class="popup-loc">' +
                '<span class="material-symbols-outlined" style="font-size:13px;color:#785a06;">location_on</span>' +
                esc(shortLoc) +
            '</p>' +

            /* Street address (lazy) */
            '<p class="popup-addr" id="' + addrId + '">' +
                '<span style="display:inline-block;width:10px;height:10px;border:1.5px solid #c0c8c3;border-top-color:#785a06;border-radius:50%;animation:spin 0.85s linear infinite;vertical-align:middle;margin-right:4px;"></span>' +
                'Loading address…' +
            '</p>' +

            /* Price */
            (price ? '<p class="popup-price"><span>From</span>' + esc(price) + ' / night</p>' : '') +

            /* Action buttons */
            '<div class="popup-actions">' +
                '<a href="' + esc(mapsUrl) + '" target="_blank" rel="noopener" class="popup-btn popup-btn-outline">' +
                    '📍 Google Maps' +
                '</a>' +
                '<a href="' + esc(hotel.url) + '" target="_blank" rel="noopener" class="popup-btn popup-btn-solid">' +
                    'TripAdvisor ↗' +
                '</a>' +
            '</div>' +

        '</div>'
    );
}

/* ═══════════════════════════════════════════════════════════════════════
   ADD MARKER
═══════════════════════════════════════════════════════════════════════ */
function addMarker(hotel) {
    if (markers[hotel.key]) return; /* already on map */

    var price = priceMin(hotel.price_ranges);
    var rating = hotel.review_summary.rating;

    /* Staggered animation delay based on index */
    var delay = Object.keys(markers).length * 22;

    var icon = L.divIcon({
        className: '',
        html: '<div class="pm-wrap" style="animation-delay:' + delay + 'ms;">' +
                  '<div class="pm" style="animation-delay:' + delay + 'ms;">' + esc(price) + '</div>' +
                  '<div class="pm-rating">' + rating.toFixed(1) + '</div>' +
              '</div>',
        iconSize:   null,
        iconAnchor: [26, 22],
        popupAnchor: [0, -24]
    });

    var marker = L.marker([hotel.geo.latitude, hotel.geo.longitude], {
        icon:       icon,
        riseOnHover: true,
        title:      hotel.name
    });

    marker.bindPopup(buildPopup(hotel), {
        maxWidth:   280,
        minWidth:   270,
        closeButton: true,
        autoClose:  true,
        className:  'sultan-popup'
    });

    marker.on('click', function() {
        /* Highlight active row in list */
        highlightRow(hotel.key);
        /* Update marker style */
        setActiveMarker(hotel.key);
        /* Drain address queue */
        drainAddrQueue();
    });

    marker.on('popupclose', function() {
        var el = marker.getElement();
        if (el) {
            var pm = el.querySelector('.pm');
            if (pm) pm.classList.remove('active');
        }
        if (activeKey === hotel.key) activeKey = null;
        var row = document.getElementById('row-' + hotel.key.replace(/[^a-z0-9]/gi,'-'));
        if (row) row.classList.remove('active');
    });

    clusterGrp.addLayer(marker);
    markers[hotel.key] = marker;
}

function setActiveMarker(key) {
    /* Reset previous */
    if (activeKey && markers[activeKey]) {
        var prevEl = markers[activeKey].getElement();
        if (prevEl) { var pm = prevEl.querySelector('.pm'); if (pm) pm.classList.remove('active'); }
    }
    activeKey = key;
    if (markers[key]) {
        var el = markers[key].getElement();
        if (el) { var pm = el.querySelector('.pm'); if (pm) pm.classList.add('active'); }
    }
}

/* ═══════════════════════════════════════════════════════════════════════
   HOTEL LIST IN PANEL
═══════════════════════════════════════════════════════════════════════ */
function renderList(list) {
    listEl.innerHTML = '';
    if (!list.length) {
        listEl.innerHTML = '<p style="text-align:center;font-size:12px;color:#a0a09a;padding:12px 0;">No hotels found.</p>';
        return;
    }
    list.forEach(function(hotel) {
        var rowId  = 'row-' + hotel.key.replace(/[^a-z0-9]/gi,'-');
        var row    = document.createElement('div');
        row.className = 'hotel-row';
        row.id    = rowId;
        row.innerHTML =
            '<img class="hotel-row-img" src="' + esc(hotel.image || '') + '" alt="" '
              + 'onerror="this.src=\'\';this.style.background=\'#e5e2dd\';" />' +
            '<div class="hotel-row-info">' +
                '<p class="hotel-row-name">' + esc(hotel.name) + '</p>' +
                '<p class="hotel-row-loc">' + esc(cityFromUrl(hotel.url)) + ', Morocco</p>' +
            '</div>' +
            '<span class="hotel-row-price">' + esc(priceMin(hotel.price_ranges)) + '</span>';

        row.addEventListener('click', function() {
            var m = markers[hotel.key];
            if (!m) return;
            /* Fly to marker */
            map.flyTo(m.getLatLng(), 14, { duration: 1.2 });
            setTimeout(function() {
                clusterGrp.zoomToShowLayer(m, function() {
                    m.openPopup();
                    setActiveMarker(hotel.key);
                    highlightRow(hotel.key);
                });
            }, 100);
        });

        listEl.appendChild(row);
    });
}

function highlightRow(key) {
    document.querySelectorAll('.hotel-row').forEach(function(r) { r.classList.remove('active'); });
    var rowId = 'row-' + key.replace(/[^a-z0-9]/gi,'-');
    var row   = document.getElementById(rowId);
    if (row) {
        row.classList.add('active');
        row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

/* ═══════════════════════════════════════════════════════════════════════
   SEARCH / FILTER LIST
═══════════════════════════════════════════════════════════════════════ */
function filterList(query) {
    var q = query.toLowerCase().trim();
    var visible = q
        ? hotels.filter(function(h) {
            return h.name.toLowerCase().includes(q) ||
                   cityFromUrl(h.url).toLowerCase().includes(q);
          })
        : hotels;
    renderList(visible);
}

/* ═══════════════════════════════════════════════════════════════════════
   FETCH HOTELS
═══════════════════════════════════════════════════════════════════════ */
function loadHotels(off, srt, append) {
    if (isBusy) return;
    isBusy = true;
    moreBtn.disabled = true;

    if (!append) {
        loadingOverlay.classList.remove('hidden');
        loadingText.textContent = 'Loading hotels on map…';
    } else {
        moreBtn.innerHTML = '<span style="display:inline-block;width:12px;height:12px;border:2px solid rgba(255,255,255,0.4);border-top-color:#fff;border-radius:50%;animation:spin 0.7s linear infinite;vertical-align:middle;margin-right:6px;"></span> Loading…';
    }

    fetch(API_BASE + '?offset=' + off + '&limit=' + PAGE_SIZE + '&sort=' + srt)
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (data.error) throw new Error(data.error.message);

            var list = data.result.list;
            total    = data.result.total_count;
            offset   = off + list.length;

            hotels = append ? hotels.concat(list) : list;

            /* Add markers */
            list.forEach(function(hotel) { addMarker(hotel); });

            /* Fit map to Morocco bounds on first load */
            if (!append && Object.keys(markers).length > 0) {
                try {
                    var group = L.featureGroup(Object.values(markers));
                    map.fitBounds(group.getBounds().pad(0.15));
                } catch(e) {}
            }

            /* Update UI */
            renderList(hotels);
            countEl.textContent = hotels.length + ' of ' + total.toLocaleString() + ' hotels';

            if (offset < total) {
                moreBtn.classList.remove('hidden');
                pageInfoEl.textContent = 'Loaded ' + hotels.length + ' of ' + total.toLocaleString();
            } else {
                moreBtn.classList.add('hidden');
                pageInfoEl.textContent = 'All ' + total.toLocaleString() + ' hotels loaded ✓';
            }

            /* Hide loading overlay */
            loadingOverlay.classList.add('hidden');
        })
        .catch(function(err) {
            loadingText.textContent = '⚠ ' + err.message;
            countEl.textContent = 'Error loading hotels';
            console.error('[Map hotels]', err);
        })
        .finally(function() {
            isBusy           = false;
            moreBtn.disabled = false;
            moreBtn.innerHTML = 'Load More Hotels';
        });
}

/* ═══════════════════════════════════════════════════════════════════════
   NOMINATIM QUEUE  (1 req / 1.15 s)
═══════════════════════════════════════════════════════════════════════ */
function drainAddrQueue() {
    if (queueBusy || addrQueue.length === 0) return;
    queueBusy = true;

    (function next() {
        if (addrQueue.length === 0) { queueBusy = false; return; }
        var item     = addrQueue.shift();
        var cacheKey = item.lat + ',' + item.lon;
        var el       = document.getElementById(item.elId);
        if (!el) { next(); return; }

        if (addrCache[cacheKey]) {
            el.textContent = addrCache[cacheKey];
            next(); return;
        }

        fetch(
            'https://nominatim.openstreetmap.org/reverse?lat=' + item.lat +
            '&lon=' + item.lon + '&format=json&zoom=18&addressdetails=1',
            { headers: { 'Accept-Language': 'en-US,en' } }
        )
        .then(function(r) { return r.json(); })
        .then(function(d) {
            var a    = d.address || {};
            var road = a.road || a.pedestrian || a.footway || a.neighbourhood || a.suburb || '';
            var num  = a.house_number || '';
            var addr = [num, road].filter(Boolean).join(' ')
                    || (d.display_name || '').split(',')[0]
                    || 'Address unavailable';
            addrCache[cacheKey] = addr;
            var el2 = document.getElementById(item.elId);
            if (el2) el2.textContent = addr;
        })
        .catch(function() {
            var el2 = document.getElementById(item.elId);
            if (el2) el2.textContent = 'Address unavailable';
        })
        .finally(function() { setTimeout(next, 1150); });
    })();
}

/* ═══════════════════════════════════════════════════════════════════════
   PANEL TOGGLE
═══════════════════════════════════════════════════════════════════════ */
closeBtn.addEventListener('click', function() {
    panel.classList.add('collapsed');
    toggleBtn.classList.add('show');
});
toggleBtn.addEventListener('click', function() {
    panel.classList.remove('collapsed');
    toggleBtn.classList.remove('show');
});

/* ═══════════════════════════════════════════════════════════════════════
   SORT & SEARCH EVENTS
═══════════════════════════════════════════════════════════════════════ */
sortEl.addEventListener('change', function() {
    sortBy  = sortEl.value;
    offset  = 0;
    hotels  = [];
    markers = {};
    clusterGrp.clearLayers();
    loadHotels(0, sortBy, false);
});

moreBtn.addEventListener('click', function() {
    loadHotels(offset, sortBy, true);
});

var searchTimeout;
searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        filterList(searchInput.value);
    }, 200);
});

/* ═══════════════════════════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════════════════════════ */
loadHotels(0, sortBy, false);
</script>
<x-chatbot />
</body>
</html>
