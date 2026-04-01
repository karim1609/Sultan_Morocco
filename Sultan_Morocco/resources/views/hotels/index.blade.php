<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotels in Morocco — Sultan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Custom keyframes ─────────────────────────────── */
        @keyframes sk-shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        @keyframes card-rise {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes hero-up {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes heart-pop {
            0%   { transform: scale(1);   }
            30%  { transform: scale(1.45); }
            60%  { transform: scale(0.9); }
            100% { transform: scale(1);   }
        }
        @keyframes pill-in {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes count-fade {
            0%   { opacity: 0; transform: translateY(-6px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ── Skeleton shimmer ─────────────────────────────── */
        .sk {
            background: linear-gradient(90deg,
                #ede9e4 25%, #e2ddd7 50%, #ede9e4 75%);
            background-size: 300% 100%;
            animation: sk-shimmer 1.8s ease-in-out infinite;
        }

        /* ── Card animation class ─────────────────────────── */
        .card-animate {
            animation: card-rise 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* ── Hero text stagger ────────────────────────────── */
        .hero-line { animation: hero-up 0.8s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .hero-line:nth-child(1) { animation-delay: 0.05s; }
        .hero-line:nth-child(2) { animation-delay: 0.18s; }
        .hero-line:nth-child(3) { animation-delay: 0.30s; }

        /* ── Pill animation ───────────────────────────────── */
        .pill-animate { animation: pill-in 0.4s cubic-bezier(0.22, 1, 0.36, 1) both; }

        /* ── Heart pop ────────────────────────────────────── */
        .heart-pop { animation: heart-pop 0.45s ease; }

        /* ── Count fade ───────────────────────────────────── */
        .count-animate { animation: count-fade 0.35s ease both; }

        /* ── Smooth card hover lift ───────────────────────── */
        .hotel-card {
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hotel-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px -8px rgba(0,0,0,0.18),
                        0 8px 16px -4px rgba(0,0,0,0.08);
        }

        /* ── Image zoom ───────────────────────────────────── */
        .hotel-card .card-img {
            transition: transform 0.55s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hotel-card:hover .card-img { transform: scale(1.08); }

        /* ── Pill active ──────────────────────────────────── */
        .city-pill {
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .city-pill.active {
            background-color: #00261a;
            color: #ffffff;
            border-color: #00261a;
        }

        /* ── Address spinner ──────────────────────────────── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .addr-spin {
            display: inline-block;
            width: 10px; height: 10px;
            border: 1.5px solid #c0c8c3;
            border-top-color: #785a06;
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
            vertical-align: middle;
            margin-right: 4px;
        }

        /* ── No-scrollbar ─────────────────────────────────── */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Grid fade on filter change ───────────────────── */
        .grid-fade-out { opacity: 0; transform: translateY(8px); transition: opacity 0.2s, transform 0.2s; }
        .grid-fade-in  { opacity: 1; transform: translateY(0);   transition: opacity 0.3s, transform 0.3s; }

        /* ── Load more loading state ──────────────────────── */
        @keyframes btn-spin { to { transform: rotate(360deg); } }
        .btn-spinner {
            display: inline-block;
            width: 14px; height: 14px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: btn-spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 6px;
        }
    </style>
</head>
<body class="bg-background font-body text-on-background selection:bg-secondary-container selection:text-on-secondary-container">

{{-- ═══════════════════════════ TOP NAV ════════════════════════════════ --}}
<nav class="fixed top-0 z-50 w-full bg-surface/80 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4 md:px-8">

        <a href="{{ url('/') }}" class="font-headline text-2xl font-bold text-emerald-900 dark:text-emerald-400">
            Sultan
        </a>

        <div class="hidden items-center gap-8 md:flex">
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}">Home</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#destinations">Explore</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ route('map.index') }}">Map</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#categories">Restaurants</a>
            <a class="border-b-2 border-amber-500 pb-1 font-body text-sm font-medium uppercase tracking-wider text-emerald-900 dark:text-emerald-400"
               href="{{ route('hotels.index') }}">Hotels</a>
            <a class="font-body text-sm font-medium uppercase tracking-wider text-stone-600 transition-colors hover:text-emerald-700 dark:text-stone-400 dark:hover:text-emerald-300"
               href="{{ url('/') }}#experiences">Experiences</a>
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            @auth
                <span class="hidden max-w-[10rem] truncate text-xs font-medium text-stone-600 sm:inline dark:text-stone-400">
                    Hi, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('profile', Auth::id()) }}"
                   class="hidden rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high sm:inline">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-stone-600 transition hover:bg-surface-container-high dark:text-stone-400">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-full border border-outline-variant/40 px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-primary transition hover:bg-surface-container-high">
                    Log in
                </a>
                <a href="{{ route('signup') }}"
                   class="rounded-full bg-primary px-3 py-1.5 font-body text-xs font-semibold uppercase tracking-wider text-on-primary transition hover:opacity-90">
                    Sign up
                </a>
            @endauth
            <button type="button" class="rounded-full p-2 transition-colors hover:bg-surface-container-high" aria-label="Search">
                <span class="material-symbols-outlined text-emerald-900 dark:text-emerald-400">search</span>
            </button>
            <a href="{{ auth()->check() ? route('profile', auth()->id()) : route('login') }}"
               class="rounded-full p-2 transition-colors hover:bg-surface-container-high" aria-label="Account">
                <span class="material-symbols-outlined text-emerald-900 dark:text-emerald-400">account_circle</span>
            </a>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════ HERO ═══════════════════════════════════ --}}
<header class="relative flex h-[52vh] min-h-[380px] items-end overflow-hidden">
    <div class="absolute inset-0">
        <img
            class="h-full w-full object-cover"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9__zftsu2VrpDdniBahUGwzkbBtcuYoO7XOGwGG_rmn0EHRT1h46zyiml7OzXfS2pCRuIXElrAVK071acmCemF2LN6-TUX7mJCf-D7zLVVqOlM5RxweuZcVauiltUvfBEQq9wNr8usHNublcpj3seyNqwdBlrXG4PYLBfYTRFW6UqMyArf-zeyZjXXq4mG4H8SLrlAZ1r3FIZSfKcF_xB3eV6LIaNZ0KW1r0aZ6CH7IWaWq7pQVbK9zJVnZBIWcbmBTUwEdhUUvs"
            alt="Luxury Moroccan riad courtyard"
            fetchpriority="high"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-primary/50 via-primary/20 to-background"></div>
    </div>
    <div class="relative z-10 mx-auto w-full max-w-7xl px-6 pb-16 md:px-8">
        <div class="hero-line">
            <span class="inline-block rounded-full border border-white/25 bg-white/10 px-4 py-1.5 font-body text-xs font-bold uppercase tracking-[0.2rem] text-white backdrop-blur-sm">
                🇲🇦 &nbsp;Xotelo · 3,000+ Properties
            </span>
        </div>
        <h1 class="hero-line mt-4 font-headline text-5xl leading-tight text-white drop-shadow-lg md:text-6xl lg:text-7xl">
            Hotels &amp; Stays<br class="hidden md:block" />in Morocco
        </h1>
        <p class="hero-line mt-3 max-w-lg font-body text-base font-light text-white/80 md:text-lg">
            Riads, resorts, and boutique guesthouses — curated for every traveller.
        </p>
    </div>
</header>

{{-- ═══════════════════════════ CITY PILLS ═════════════════════════════ --}}
<div class="border-b border-outline-variant/30 bg-surface/95 backdrop-blur-md">
    <div class="mx-auto max-w-7xl px-6 md:px-8">
        <div id="city-pills"
             class="no-scrollbar flex items-center gap-2 overflow-x-auto py-4"
             role="tablist"
             aria-label="Filter by city">
            {{-- Pills injected by JS --}}
        </div>
    </div>
</div>

{{-- ═══════════════════════════ SORT BAR ═══════════════════════════════ --}}
<div class="sticky top-16 z-40 border-b border-outline-variant/20 bg-surface/95 backdrop-blur-md shadow-sm">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-6 py-3 md:px-8">
        <div class="flex items-center gap-2 rounded-full border border-outline-variant/40 bg-surface-container-low px-4 py-2">
            <span class="material-symbols-outlined text-[18px] leading-none text-secondary">sort</span>
            <select id="sort-sel"
                    class="cursor-pointer border-none bg-transparent font-body text-sm text-on-surface focus:outline-none focus:ring-0">
                <option value="best_value">Best Value</option>
                <option value="popularity">Most Popular</option>
            </select>
        </div>
        <span id="result-count" class="font-body text-sm text-on-surface-variant">
            Loading hotels…
        </span>
    </div>
</div>

{{-- ═══════════════════════════ MAIN ═══════════════════════════════════ --}}
<main class="mx-auto max-w-7xl px-6 py-8 md:px-8">

    {{-- Section header --}}
    <div class="mb-6">
        <span class="mb-1 block font-body text-xs font-bold uppercase tracking-[0.2rem] text-secondary">
            Available Now
        </span>
        <h2 class="font-headline text-3xl text-on-surface md:text-4xl">Find Your Stay</h2>
    </div>

    {{-- Cards grid --}}
    <div id="grid"
         class="grid grid-cols-2 gap-4 md:grid-cols-4"
         role="list">
    </div>

    {{-- Load more --}}
    <div class="mt-14 flex flex-col items-center gap-3">
        <button id="load-more"
                class="hidden rounded-full bg-gradient-to-br from-primary to-primary-container px-10 py-4 font-body text-sm font-bold uppercase tracking-widest text-white shadow-lg transition-all hover:scale-[0.98] hover:opacity-90 active:scale-95 disabled:cursor-not-allowed disabled:opacity-50">
            Load More Hotels
        </button>
        <p id="page-info" class="font-body text-sm text-on-surface-variant"></p>
    </div>
</main>

{{-- ═══════════════════════════ FOOTER ════════════════════════════════ --}}
<footer class="mt-8 border-t border-outline-variant/20 bg-surface-container-low py-12 text-center">
    <p class="font-body text-sm text-on-surface-variant">
        Powered by
        <a href="https://xotelo.com" target="_blank" rel="noopener"
           class="font-semibold text-primary underline-offset-2 hover:underline">Xotelo Hotel API</a>
        &amp;
        <a href="https://nominatim.openstreetmap.org" target="_blank" rel="noopener"
           class="font-semibold text-primary underline-offset-2 hover:underline">OpenStreetMap / Nominatim</a>
        &nbsp;·&nbsp; Hotel data sourced from TripAdvisor
    </p>
</footer>

{{-- ═══════════════════════════ JAVASCRIPT ════════════════════════════ --}}
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
var filtered   = [];
var favorites  = {};
var cityFilter = 'all';
var sortBy     = 'best_value';
var offset     = 0;
var total      = 0;
var isBusy     = false;

/* Nominatim queue */
var addrCache = {};
var addrQueue = [];
var queueBusy = false;

/* ═══════════════════════════════════════════════════════════════════════
   DOM REFS
═══════════════════════════════════════════════════════════════════════ */
var grid      = document.getElementById('grid');
var pillsEl   = document.getElementById('city-pills');
var sortEl    = document.getElementById('sort-sel');
var countEl   = document.getElementById('result-count');
var moreBtn   = document.getElementById('load-more');
var pageInfo  = document.getElementById('page-info');

/* ═══════════════════════════════════════════════════════════════════════
   HELPERS
═══════════════════════════════════════════════════════════════════════ */
function esc(s) {
    return String(s)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function pause(ms) { return new Promise(function(r){ setTimeout(r, ms); }); }

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

function renderStars(r) {
    var f = Math.round(r);
    return '★'.repeat(f) + '☆'.repeat(5 - f);
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

function typeBadgeBg(type) {
    var t = (type || '').toLowerCase().replace(/\s+/g,'');
    if (t.includes('hostel'))     return '#5b21b6';
    if (t.includes('resort'))     return '#92400e';
    if (t.includes('guest'))      return '#065f46';
    if (t.includes('smallhotel')) return '#1e3a8a';
    return '#00261a';
}

function priceStr(p) {
    return p ? '$' + p.minimum + ' – $' + p.maximum : null;
}

/* ═══════════════════════════════════════════════════════════════════════
   CARD HTML  — Booking.com inspired, Sultan design tokens
═══════════════════════════════════════════════════════════════════════ */
function cardHTML(hotel, animDelay) {
    var cardId   = 'card-' + hotel.key.replace(/[^a-z0-9]/gi, '-');
    var addrId   = 'addr-' + cardId;
    var shortLoc = shortLocFromUrl(hotel.url);
    var city     = cityFromUrl(hotel.url);
    var mapsUrl  = 'https://maps.google.com/?q=' + hotel.geo.latitude + ',' + hotel.geo.longitude;
    var price    = priceStr(hotel.price_ranges);
    var rating   = hotel.review_summary.rating;
    var isFav    = favorites[hotel.key] ? true : false;

    var imgHTML = hotel.image
        ? '<img src="' + esc(hotel.image) + '" alt="' + esc(hotel.name) + '" ' +
          'loading="lazy" class="card-img h-full w-full object-cover" ' +
          'onerror="this.parentElement.innerHTML=\'<div style=\\\"background:#f0ede9;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;\\\">🏨</div>\'" />'
        : '<div style="background:#f0ede9;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;">🏨</div>';

    var heartFill   = isFav ? '#e11d48' : 'none';
    var heartStroke = isFav ? '#e11d48' : 'currentColor';

    var labelsHTML = '';
    (hotel.merchandising_labels || []).forEach(function(l) {
        labelsHTML += '<span style="background:rgba(120,90,6,0.1);color:#5b4300;border:1px solid rgba(120,90,6,0.25);padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;">✓ ' + esc(l) + '</span>';
    });

    return (
        '<article class="hotel-card card-animate flex flex-col overflow-hidden rounded-xl bg-white"' +
            ' id="' + cardId + '" role="listitem"' +
            ' style="animation-delay:' + animDelay + 'ms; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">' +

            /* ── Image ── */
            '<div class="relative overflow-hidden" style="height:160px;">' +
                imgHTML +

                /* Gradient bottom fade */
                '<div class="absolute inset-x-0 bottom-0 h-16" ' +
                     'style="background:linear-gradient(to top,rgba(0,0,0,0.35),transparent);pointer-events:none;"></div>' +

                /* Heart button */
                '<button class="heart-btn absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 shadow-md backdrop-blur-sm transition-transform hover:scale-110 active:scale-90"' +
                        ' data-key="' + esc(hotel.key) + '" aria-label="Save to favourites" type="button">' +
                    '<svg width="18" height="18" viewBox="0 0 24 24" fill="' + heartFill + '"' +
                         ' stroke="' + heartStroke + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
                        '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>' +
                    '</svg>' +
                '</button>' +

                /* Type badge */
                '<span class="absolute bottom-3 left-3 rounded-full px-2.5 py-0.5 font-body text-[11px] font-bold text-white"' +
                      ' style="background:' + typeBadgeBg(hotel.accommodation_type) + ';backdrop-filter:blur(4px);">' +
                    esc(hotel.accommodation_type || 'Hotel') +
                '</span>' +
            '</div>' +

            /* ── Body ── */
            '<div class="flex flex-1 flex-col gap-1.5 px-3 py-2.5">' +

                /* Name */
                '<h3 class="font-headline text-sm font-bold leading-snug text-on-surface" ' +
                    'style="display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;">' +
                    esc(hotel.name) +
                '</h3>' +

                /* Location */
                '<p class="flex items-center gap-0.5 font-body text-[11px] text-on-surface-variant">' +
                    '<span class="material-symbols-outlined text-[12px] leading-none text-secondary">location_on</span>' +
                    esc(shortLoc) +
                '</p>' +

                /* Street address (lazy) */
                '<p id="' + addrId + '"' +
                   ' class="font-body text-[10px] italic text-on-surface-variant/60"' +
                   ' data-lat="' + hotel.geo.latitude + '"' +
                   ' data-lon="' + hotel.geo.longitude + '">' +
                    '<span class="addr-spin"></span>Loading…' +
                '</p>' +

                /* Rating row */
                '<div class="mt-1 flex items-center gap-2">' +
                    '<span class="flex-shrink-0 rounded-md px-1.5 py-0.5 font-body text-xs font-bold text-white"' +
                          ' style="background:' + ratingBg(rating) + ';">' +
                        rating.toFixed(1) +
                    '</span>' +
                    '<p class="font-body text-xs font-semibold text-on-surface">' + ratingLabel(rating) + '</p>' +
                    '<p class="font-body text-[10px] text-on-surface-variant">· ' +
                        hotel.review_summary.count.toLocaleString() +
                    '</p>' +
                '</div>' +

                /* Labels (one line max) */
                (labelsHTML ? '<div class="flex flex-wrap gap-1">' + labelsHTML + '</div>' : '') +

            '</div>' +

            /* ── Footer ── */
            '<div class="mt-auto flex items-center justify-between border-t border-outline-variant/20 bg-surface-container-low/40 px-3 py-2">' +
                '<a href="' + esc(mapsUrl) + '" target="_blank" rel="noopener"' +
                   ' class="inline-flex items-center gap-0.5 font-body text-[11px] font-semibold text-primary transition-colors hover:text-primary-container">' +
                    '<span class="material-symbols-outlined text-[13px] leading-none">map</span>' +
                    'Map' +
                '</a>' +

                (price
                    ? '<p class="font-body text-xs font-bold text-on-surface">' + esc(price) + '</p>'
                    : '') +

                '<a href="' + esc(hotel.url) + '" target="_blank" rel="noopener"' +
                   ' class="rounded-full px-2.5 py-1 font-body text-[10px] font-bold uppercase tracking-wider text-white transition-all hover:opacity-90"' +
                   ' style="background:linear-gradient(135deg,#00261a,#0f3d2e);">' +
                    'View ↗' +
                '</a>' +
            '</div>' +

        '</article>'
    );
}

/* ═══════════════════════════════════════════════════════════════════════
   SKELETON CARDS
═══════════════════════════════════════════════════════════════════════ */
function showSkeletons(n) {
    var sk = '';
    for (var i = 0; i < n; i++) {
        sk +=
            '<div class="overflow-hidden rounded-xl bg-white" style="box-shadow:0 2px 10px rgba(0,0,0,0.08);" aria-hidden="true">' +
                '<div class="sk" style="height:160px;"></div>' +
                '<div style="padding:10px 12px;display:flex;flex-direction:column;gap:8px;">' +
                    '<div class="sk" style="height:14px;width:85%;border-radius:20px;"></div>' +
                    '<div class="sk" style="height:11px;width:55%;border-radius:20px;"></div>' +
                    '<div class="sk" style="height:10px;width:70%;border-radius:20px;"></div>' +
                    '<div style="display:flex;gap:8px;align-items:center;">' +
                        '<div class="sk" style="height:22px;width:34px;border-radius:6px;"></div>' +
                        '<div class="sk" style="height:11px;width:50%;border-radius:20px;"></div>' +
                    '</div>' +
                '</div>' +
                '<div style="border-top:1px solid rgba(0,0,0,0.07);padding:7px 12px;display:flex;justify-content:space-between;gap:8px;">' +
                    '<div class="sk" style="height:22px;width:40px;border-radius:20px;"></div>' +
                    '<div class="sk" style="height:22px;width:60px;border-radius:20px;"></div>' +
                    '<div class="sk" style="height:22px;width:48px;border-radius:20px;"></div>' +
                '</div>' +
            '</div>';
    }
    grid.innerHTML = sk;
}

/* ═══════════════════════════════════════════════════════════════════════
   RESULT COUNT
═══════════════════════════════════════════════════════════════════════ */
function updateCount() {
    countEl.innerHTML = '';
    var span = document.createElement('span');
    span.className = 'count-animate';
    span.innerHTML =
        'Showing <strong style="color:#1c1c19;">' + filtered.length + '</strong>' +
        ' of <strong style="color:#1c1c19;">' + total.toLocaleString() + '</strong> hotels';
    countEl.appendChild(span);
}

/* ═══════════════════════════════════════════════════════════════════════
   CITY PILLS
═══════════════════════════════════════════════════════════════════════ */
function buildPills(list) {
    /* Collect unique cities preserving first-seen order */
    var seen = {};
    var cities = ['all'];
    list.forEach(function(h) {
        var c = cityFromUrl(h.url);
        if (!seen[c]) { seen[c] = true; cities.push(c); }
    });
    cities.sort(function(a,b){ return a === 'all' ? -1 : b === 'all' ? 1 : a.localeCompare(b); });

    pillsEl.innerHTML = '';
    cities.forEach(function(c, i) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'city-pill pill-animate flex-shrink-0 rounded-full border border-outline-variant/50 bg-surface-container-low px-4 py-2 font-body text-sm font-medium text-on-surface-variant';
        btn.style.animationDelay = (i * 35) + 'ms';
        btn.dataset.city = c;
        btn.textContent  = c === 'all' ? '🌍  All Cities' : c;
        btn.setAttribute('role', 'tab');
        btn.setAttribute('aria-selected', c === cityFilter ? 'true' : 'false');
        if (c === cityFilter) btn.classList.add('active');
        btn.addEventListener('click', function() {
            cityFilter = c;
            document.querySelectorAll('.city-pill').forEach(function(p){
                p.classList.toggle('active', p.dataset.city === c);
                p.setAttribute('aria-selected', p.dataset.city === c ? 'true' : 'false');
            });
            animateGridChange(function(){ applyFilter(); });
        });
        pillsEl.appendChild(btn);
    });
}

/* ═══════════════════════════════════════════════════════════════════════
   GRID TRANSITION ON FILTER CHANGE
═══════════════════════════════════════════════════════════════════════ */
function animateGridChange(callback) {
    grid.classList.add('grid-fade-out');
    setTimeout(function() {
        callback();
        grid.classList.remove('grid-fade-out');
        grid.classList.add('grid-fade-in');
        setTimeout(function(){ grid.classList.remove('grid-fade-in'); }, 350);
    }, 200);
}

/* ═══════════════════════════════════════════════════════════════════════
   APPLY CITY FILTER
═══════════════════════════════════════════════════════════════════════ */
function applyFilter() {
    filtered = cityFilter === 'all'
        ? hotels.slice()
        : hotels.filter(function(h){ return cityFromUrl(h.url) === cityFilter; });
    renderCards(filtered, false);
}

/* ═══════════════════════════════════════════════════════════════════════
   RENDER CARDS
═══════════════════════════════════════════════════════════════════════ */
function renderCards(list, append) {
    if (!append) grid.innerHTML = '';

    if (!list.length && !append) {
        grid.innerHTML =
            '<div style="grid-column:1/-1;text-align:center;padding:80px 32px;">' +
                '<span class="material-symbols-outlined" style="font-size:3.5rem;color:#c0c8c3;display:block;margin-bottom:12px;">hotel</span>' +
                '<p class="font-body text-on-surface-variant">No hotels found for this city.</p>' +
            '</div>';
        updateCount();
        return;
    }

    var frag = document.createDocumentFragment();
    list.forEach(function(hotel, idx) {
        var baseDelay = append ? 0 : idx * 55;
        var wrap = document.createElement('div');
        wrap.innerHTML = cardHTML(hotel, baseDelay);
        var card = wrap.firstElementChild;
        frag.appendChild(card);

        /* observe address span */
        var addrEl = card.querySelector('[data-lat]');
        if (addrEl) addrObserver.observe(addrEl);
    });
    grid.appendChild(frag);

    /* wire up heart buttons */
    bindHeartButtons();
    updateCount();
}

/* ═══════════════════════════════════════════════════════════════════════
   HEART / FAVOURITE TOGGLE
═══════════════════════════════════════════════════════════════════════ */
function bindHeartButtons() {
    document.querySelectorAll('.heart-btn').forEach(function(btn) {
        if (btn._bound) return;
        btn._bound = true;
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var key = btn.dataset.key;
            favorites[key] = !favorites[key];
            var svg   = btn.querySelector('svg');
            var isFav = favorites[key];
            svg.setAttribute('fill',   isFav ? '#e11d48' : 'none');
            svg.setAttribute('stroke', isFav ? '#e11d48' : 'currentColor');
            btn.classList.remove('heart-pop');
            void btn.offsetWidth; /* reflow to restart animation */
            btn.classList.add('heart-pop');
        });
    });
}

/* ═══════════════════════════════════════════════════════════════════════
   FETCH HOTELS FROM LARAVEL PROXY  →  Xotelo /list
═══════════════════════════════════════════════════════════════════════ */
function loadHotels(off, srt, append) {
    if (isBusy) return;
    isBusy = true;
    moreBtn.disabled = true;

    if (!append) {
        showSkeletons(8);
    } else {
        moreBtn.innerHTML = '<span class="btn-spinner"></span> Loading…';
    }

    fetch(API_BASE + '?offset=' + off + '&limit=' + PAGE_SIZE + '&sort=' + srt)
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (data.error) throw new Error(data.error.message);

            var list  = data.result.list;
            total     = data.result.total_count;
            offset    = off + list.length;

            if (append) {
                hotels   = hotels.concat(list);
                var newF = cityFilter === 'all'
                    ? list
                    : list.filter(function(h){ return cityFromUrl(h.url) === cityFilter; });
                filtered = filtered.concat(newF);
                renderCards(newF, true);
                updateCount();
            } else {
                hotels = list;
                buildPills(list);
                applyFilter();
            }

            if (offset < total) {
                moreBtn.classList.remove('hidden');
                moreBtn.innerHTML  = 'Load More Hotels';
                pageInfo.textContent = 'Showing ' + Math.min(offset, total).toLocaleString() + ' of ' + total.toLocaleString() + ' hotels';
            } else {
                moreBtn.classList.add('hidden');
                pageInfo.textContent = 'All ' + total.toLocaleString() + ' hotels loaded ✓';
            }
        })
        .catch(function(err) {
            if (!append) {
                grid.innerHTML =
                    '<div style="grid-column:1/-1;border:1.5px solid rgba(186,26,26,0.2);background:rgba(186,26,26,0.05);border-radius:16px;padding:64px 32px;text-align:center;">' +
                        '<span class="material-symbols-outlined" style="font-size:3.5rem;color:#ba1a1a;display:block;margin-bottom:12px;">warning</span>' +
                        '<h3 class="font-headline mb-2 text-xl text-on-surface">Could not load hotels</h3>' +
                        '<p class="font-body mb-8 text-sm text-on-surface-variant">' + esc(err.message) + '</p>' +
                        '<button onclick="loadHotels(0,sortBy,false)"' +
                                ' style="background:#00261a;color:#fff;border:none;border-radius:9999px;padding:12px 32px;font-family:inherit;font-size:.875rem;font-weight:700;cursor:pointer;letter-spacing:.05em;text-transform:uppercase;">' +
                            'Try Again' +
                        '</button>' +
                    '</div>';
            }
            console.error('[Hotels]', err);
        })
        .finally(function() {
            isBusy            = false;
            moreBtn.disabled  = false;
            moreBtn.innerHTML = 'Load More Hotels';
        });
}

/* ═══════════════════════════════════════════════════════════════════════
   NOMINATIM REVERSE-GEOCODING  (queue, 1 req/s, lazy via IntersectionObserver)
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
            next();
            return;
        }

        fetch(
            'https://nominatim.openstreetmap.org/reverse?lat=' + item.lat +
            '&lon=' + item.lon + '&format=json&zoom=18&addressdetails=1',
            { headers: { 'Accept-Language': 'en-US,en' } }
        )
        .then(function(r){ return r.json(); })
        .then(function(d) {
            var a    = d.address || {};
            var road = a.road || a.pedestrian || a.footway || a.path || a.neighbourhood || a.suburb || '';
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

var addrObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
        if (e.isIntersecting) {
            var el = e.target;
            addrObserver.unobserve(el);
            addrQueue.push({ lat: el.dataset.lat, lon: el.dataset.lon, elId: el.id });
            drainAddrQueue();
        }
    });
}, { rootMargin: '120px' });

/* ═══════════════════════════════════════════════════════════════════════
   EVENTS
═══════════════════════════════════════════════════════════════════════ */
sortEl.addEventListener('change', function() {
    sortBy   = sortEl.value;
    offset   = 0;
    hotels   = [];
    filtered = [];
    animateGridChange(function() { loadHotels(0, sortBy, false); });
});

moreBtn.addEventListener('click', function() {
    loadHotels(offset, sortBy, true);
});

/* ═══════════════════════════════════════════════════════════════════════
   INIT
═══════════════════════════════════════════════════════════════════════ */
loadHotels(0, sortBy, false);
</script>
</body>
</html>
