<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Restaurants in Morocco — Sultan</title>
    <x-theme-init />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --gold: #c49a3c;
            --gold-light: #e8c97a;
            --gold-pale: #f7f0de;
            --ink: #1a1410;
            --ink-soft: #3d3329;
            --sand: #f5f0e8;
            --sand-deep: #ede5d5;
            --terracotta: #b85c38;
            --teal-dark: #0d3d30;
            --teal: #1a5e47;
            --teal-mid: #2a7a5f;
            --surface: #faf8f4;
            --muted: #8a7d6b;
            --spice: #9b3a10;
            --spice-light: #d4622a;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--surface);
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            margin: 0;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--sand); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

        /* ── SHIMMER ──────────────── */
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .sk {
            background: linear-gradient(90deg, #ede8df 25%, #e0d9cc 50%, #ede8df 75%);
            background-size: 300% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
            border-radius: 6px;
        }

        /* ── CARD REVEAL ─────────── */
        @keyframes card-rise {
            from { opacity: 0; transform: translateY(32px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .card-animate { animation: card-rise 0.6s cubic-bezier(0.22, 1, 0.36, 1) both; }

        /* ── HERO ────────────────── */
        @keyframes hero-up {
            from { opacity: 0; transform: translateY(48px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-line { animation: hero-up 1s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .hero-line:nth-child(1) { animation-delay: 0.1s; }
        .hero-line:nth-child(2) { animation-delay: 0.25s; }
        .hero-line:nth-child(3) { animation-delay: 0.4s; }
        .hero-line:nth-child(4) { animation-delay: 0.55s; }

        /* ── PILL SLIDE IN ────────── */
        @keyframes pill-in {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .pill-animate { animation: pill-in 0.4s cubic-bezier(0.22, 1, 0.36, 1) both; }

        /* ── COUNT FADE ──────────── */
        @keyframes count-fade {
            from { opacity: 0; transform: translateY(-5px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .count-animate { animation: count-fade 0.3s ease both; }

        /* ── HEART POP ──────────── */
        @keyframes heart-pop {
            0%   { transform: scale(1); }
            35%  { transform: scale(1.5); }
            65%  { transform: scale(0.88); }
            100% { transform: scale(1); }
        }
        .heart-pop { animation: heart-pop 0.45s ease; }

        /* ── SPINNER ──────────────── */
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes btn-spin { to { transform: rotate(360deg); } }
        .btn-spinner {
            display: inline-block; width: 14px; height: 14px;
            border: 2px solid rgba(255,255,255,0.35); border-top-color: #fff;
            border-radius: 50%; animation: btn-spin 0.7s linear infinite;
            vertical-align: middle; margin-right: 6px;
        }

        /* ── NAV ─────────────────── */
        .sultan-nav {
            position: fixed; top: 0; z-index: 50; width: 100%;
            background: rgba(250,248,244,0.92); backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(196,154,60,0.15);
            transition: box-shadow 0.3s ease;
        }
        .sultan-nav.scrolled { box-shadow: 0 4px 24px rgba(26,20,16,0.08); }
        .nav-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; height: 68px;
        }
        .nav-logo {
            font-family: 'Cormorant Garamond', serif; font-size: 1.75rem;
            font-weight: 600; color: var(--teal-dark); text-decoration: none;
            letter-spacing: 0.04em;
        }
        .nav-logo span { color: var(--gold); }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-link {
            font-size: 0.75rem; font-weight: 500; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--muted); text-decoration: none;
            position: relative; padding-bottom: 2px; transition: color 0.2s ease;
        }
        .nav-link:hover { color: var(--ink); }
        .nav-link.active { color: var(--teal-dark); }
        .nav-link.active::after {
            content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
            height: 1.5px; background: var(--gold);
        }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-outline-sm {
            padding: 0.4rem 1rem; border: 1px solid rgba(196,154,60,0.4);
            border-radius: 100px; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase; color: var(--teal-dark);
            text-decoration: none; transition: all 0.2s ease;
        }
        .btn-outline-sm:hover { background: var(--gold-pale); border-color: var(--gold); }
        .btn-filled-sm {
            padding: 0.4rem 1rem; background: var(--teal-dark);
            border: 1px solid var(--teal-dark); border-radius: 100px;
            font-size: 0.7rem; font-weight: 600; letter-spacing: 0.1em;
            text-transform: uppercase; color: #fff; text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-filled-sm:hover { background: var(--teal); border-color: var(--teal); }
        .nav-icon-btn {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(196,154,60,0.25); cursor: pointer;
            transition: all 0.2s ease; background: transparent;
        }
        .nav-icon-btn:hover { background: var(--gold-pale); border-color: var(--gold); }

        /* ── HERO ─────────────────── */
        .hero-section {
            position: relative; height: 60vh; min-height: 460px;
            display: flex; align-items: flex-end; overflow: hidden;
        }
        .hero-img {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; transform-origin: center;
            animation: hero-zoom 14s ease-in-out infinite alternate;
        }
        @keyframes hero-zoom {
            from { transform: scale(1); }
            to   { transform: scale(1.06); }
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom,
                rgba(155, 58, 16, 0.42) 0%,
                rgba(26, 20, 16, 0.12) 45%,
                rgba(250, 248, 244, 1) 100%);
        }
        .hero-content {
            position: relative; z-index: 2; max-width: 1280px;
            margin: 0 auto; width: 100%; padding: 0 2rem 4rem;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.4rem 1rem; background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 100px; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.9);
        }
        .hero-eyebrow::before {
            content: ''; width: 6px; height: 6px;
            border-radius: 50%; background: var(--gold-light);
        }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3rem, 7vw, 5.5rem); font-weight: 600;
            line-height: 1.05; color: #fff; margin: 1rem 0 0.75rem;
            text-shadow: 0 2px 24px rgba(0,0,0,0.25);
        }
        .hero-title em { font-style: italic; color: var(--gold-light); }
        .hero-sub {
            font-size: 1rem; font-weight: 300; color: rgba(255,255,255,0.75);
            max-width: 440px; line-height: 1.65;
        }
        .hero-stats { display: flex; gap: 2rem; margin-top: 2rem; }
        .hero-stat { display: flex; flex-direction: column; gap: 2px; }
        .hero-stat-num {
            font-family: 'Cormorant Garamond', serif; font-size: 1.6rem;
            font-weight: 600; color: var(--gold-light); line-height: 1;
        }
        .hero-stat-lbl {
            font-size: 0.65rem; letter-spacing: 0.14em;
            text-transform: uppercase; color: rgba(255,255,255,0.6);
        }

        /* ── ORNAMENT LINE ─────────── */
        .ornament-line {
            display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;
        }
        .ornament-line::before, .ornament-line::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(to right, transparent, rgba(196,154,60,0.4), transparent);
        }
        .ornament-diamond {
            width: 8px; height: 8px; background: var(--gold);
            transform: rotate(45deg); flex-shrink: 0;
        }

        /* ── PILLS BAR ─────────────── */
        .pills-bar {
            background: rgba(250,248,244,0.96); backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(196,154,60,0.12);
            position: sticky; top: 68px; z-index: 40;
        }
        .pills-inner {
            max-width: 1280px; margin: 0 auto; padding: 0.875rem 2rem;
            display: flex; align-items: center; gap: 0.5rem; overflow-x: auto;
        }
        .pills-inner::-webkit-scrollbar { display: none; }
        .city-pill {
            flex-shrink: 0; white-space: nowrap; padding: 0.45rem 1.1rem;
            border-radius: 100px; border: 1px solid rgba(196,154,60,0.3);
            background: transparent; font-size: 0.775rem; font-weight: 500;
            color: var(--muted); cursor: pointer; transition: all 0.2s ease;
        }
        .city-pill:hover { border-color: var(--gold); color: var(--ink); background: var(--gold-pale); }
        .city-pill.active { background: var(--teal-dark); color: #fff; border-color: var(--teal-dark); }

        /* ── SORT BAR ─────────────── */
        .sort-bar {
            position: sticky; top: calc(68px + 46px); z-index: 39;
            background: rgba(250,248,244,0.96); backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(196,154,60,0.08);
            box-shadow: 0 2px 12px rgba(26,20,16,0.04);
        }
        .sort-inner {
            max-width: 1280px; margin: 0 auto; padding: 0.65rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; flex-wrap: wrap;
        }
        .sort-select-wrap {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.4rem 1rem; border: 1px solid rgba(196,154,60,0.25);
            border-radius: 100px; background: var(--sand);
        }
        .sort-select-wrap select {
            border: none; background: transparent; font-family: inherit;
            font-size: 0.8rem; font-weight: 500; color: var(--ink);
            cursor: pointer; outline: none;
        }
        .result-count { font-size: 0.8rem; color: var(--muted); }
        .result-count strong { color: var(--ink); font-weight: 600; }

        /* ── MAIN ─────────────────── */
        main { max-width: 1280px; margin: 0 auto; padding: 3rem 2rem 4rem; }
        .section-header { margin-bottom: 2.5rem; }
        .section-eyebrow {
            font-size: 0.65rem; font-weight: 600; letter-spacing: 0.2em;
            text-transform: uppercase; color: var(--gold); margin-bottom: 0.5rem;
        }
        .section-title {
            font-family: 'Cormorant Garamond', serif; font-size: 2.25rem;
            font-weight: 600; color: var(--ink);
        }

        /* ── GRID ─────────────────── */
        #grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem; }
        @media (max-width: 900px) { #grid { grid-template-columns: repeat(2, 1fr); gap: 1.25rem; } }
        @media (max-width: 540px)  { #grid { grid-template-columns: 1fr; gap: 1rem; } }

        /* ── CARD ─────────────────── */
        .rest-card {
            background: #fff; border-radius: 16px; overflow: hidden;
            border: 1px solid rgba(196,154,60,0.1);
            display: flex; flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.22,1,0.36,1),
                        box-shadow 0.35s cubic-bezier(0.22,1,0.36,1),
                        border-color 0.25s ease;
        }
        .rest-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 28px 56px -10px rgba(26,20,16,0.14), 0 8px 20px -4px rgba(196,154,60,0.12);
            border-color: rgba(196,154,60,0.3);
        }
        .card-img-wrap { position: relative; overflow: hidden; height: 200px; }
        .card-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.22,1,0.36,1); }
        .rest-card:hover .card-img { transform: scale(1.09); }
        .card-img-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(155,58,16,0.55) 0%, transparent 55%);
            pointer-events: none;
        }
        .heart-btn {
            position: absolute; top: 12px; right: 12px; width: 36px; height: 36px;
            border-radius: 50%; background: rgba(255,255,255,0.9); backdrop-filter: blur(6px);
            border: none; cursor: pointer; display: flex; align-items: center;
            justify-content: center; transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .heart-btn:hover { transform: scale(1.12); box-shadow: 0 4px 14px rgba(0,0,0,0.18); }
        .cuisine-badge {
            position: absolute; bottom: 12px; left: 12px; padding: 3px 10px;
            border-radius: 100px; font-size: 10px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase; color: #fff;
            backdrop-filter: blur(6px);
        }
        .price-pill {
            position: absolute; bottom: 12px; right: 12px; padding: 3px 10px;
            border-radius: 100px; font-size: 11px; font-weight: 700;
            background: rgba(196,154,60,0.92); color: #fff;
        }
        .card-body {
            padding: 1rem 1.1rem 0.75rem; flex: 1;
            display: flex; flex-direction: column; gap: 0.5rem;
        }
        .card-name {
            font-family: 'Cormorant Garamond', serif; font-size: 1.15rem;
            font-weight: 600; line-height: 1.25; color: var(--ink);
            display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;
        }
        .card-city {
            display: flex; align-items: center; gap: 3px;
            font-size: 0.75rem; color: var(--muted);
        }
        .card-city .material-symbols-outlined { font-size: 13px; color: var(--gold); }
        .card-rating-row { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem; }
        .rating-score {
            padding: 2px 7px; border-radius: 6px; font-size: 0.78rem;
            font-weight: 700; color: #fff;
        }
        .rating-label { font-size: 0.78rem; font-weight: 600; color: var(--ink); }
        .rating-count { font-size: 0.68rem; color: var(--muted); }
        .card-specialties { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 0.3rem; }
        .specialty-chip {
            font-size: 0.63rem; font-weight: 500; padding: 2px 8px;
            border-radius: 100px; background: rgba(155,58,16,0.07);
            color: var(--spice); border: 1px solid rgba(155,58,16,0.18);
        }
        .card-labels { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 0.2rem; }
        .card-label {
            font-size: 0.63rem; font-weight: 600; letter-spacing: 0.04em;
            padding: 2px 8px; border-radius: 100px;
            background: rgba(196,154,60,0.1); color: #7a5500;
            border: 1px solid rgba(196,154,60,0.25);
        }
        .card-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.65rem 1.1rem 0.9rem;
            border-top: 1px solid rgba(196,154,60,0.1); margin-top: auto; gap: 0.4rem;
        }
        .card-price-display {
            font-family: 'Cormorant Garamond', serif; font-size: 1.15rem;
            font-weight: 700; color: var(--teal-dark); letter-spacing: 0.05em;
        }
        .card-map-link {
            display: inline-flex; align-items: center; gap: 3px; font-size: 0.7rem;
            font-weight: 600; color: var(--muted); text-decoration: none;
            transition: color 0.2s ease;
        }
        .card-map-link:hover { color: var(--teal); }
        .card-map-link .material-symbols-outlined { font-size: 14px; }
        .card-cta {
            display: inline-block; padding: 0.45rem 1.1rem;
            background: linear-gradient(135deg, var(--teal-dark), var(--teal-mid));
            color: #fff; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase; border-radius: 100px;
            text-decoration: none; transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(13,61,48,0.25); white-space: nowrap;
        }
        .card-cta:hover {
            background: linear-gradient(135deg, var(--teal), #3a8f6f);
            box-shadow: 0 4px 18px rgba(13,61,48,0.35); transform: translateY(-1px);
        }

        /* ── SKELETON ─────────────── */
        .sk-card {
            background: #fff; border-radius: 16px; overflow: hidden;
            border: 1px solid rgba(196,154,60,0.08);
        }

        /* ── GRID TRANSITION ─────── */
        .grid-fade-out { opacity: 0; transform: translateY(10px); transition: opacity 0.2s, transform 0.2s; }
        .grid-fade-in  { opacity: 1; transform: translateY(0);    transition: opacity 0.3s, transform 0.3s; }

        /* ── LOAD MORE ────────────── */
        .load-more-wrap { text-align: center; margin-top: 4rem; }
        .load-more-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.9rem 2.5rem;
            background: linear-gradient(135deg, var(--teal-dark), var(--teal-mid));
            color: #fff; font-size: 0.75rem; font-weight: 600;
            letter-spacing: 0.12em; text-transform: uppercase; border: none;
            border-radius: 100px; cursor: pointer;
            box-shadow: 0 6px 24px rgba(13,61,48,0.28); transition: all 0.3s ease;
        }
        .load-more-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(13,61,48,0.36); }
        .load-more-btn:active { transform: scale(0.98); }
        .load-more-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .load-more-btn.hidden { display: none; }
        #page-info { font-size: 0.8rem; color: var(--muted); margin-top: 0.75rem; }

        /* ── FOOTER ───────────────── */
        .sultan-footer {
            border-top: 1px solid rgba(196,154,60,0.12);
            background: var(--sand); padding: 3rem 2rem; text-align: center;
        }
        .footer-logo {
            font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;
            color: var(--teal-dark); font-weight: 600; margin-bottom: 0.75rem;
        }
        .footer-logo span { color: var(--gold); }
        .footer-credit { font-size: 0.78rem; color: var(--muted); line-height: 1.8; }
        .footer-credit a { color: var(--teal); font-weight: 500; }

        /* ── NO SCROLLBAR ─────────── */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── RESPONSIVE NAV ───────── */
        @media (max-width: 768px) { .nav-links { display: none; } }

        /* ── DARK MODE ─────────────── */
        html.dark {
            --gold: #d4af5e;
            --gold-light: #ecd089;
            --gold-pale: #2a2318;
            --ink: #f4f0e8;
            --ink-soft: #b5a99a;
            --sand: #1e1c18;
            --sand-deep: #2a2620;
            --terracotta: #e8956a;
            --teal-dark: #5eead4;
            --teal: #34d399;
            --teal-mid: #2dd4bf;
            --surface: #141210;
            --muted: #9c9082;
            --spice: #f08060;
            --spice-light: #f4a580;
        }
        html.dark body { background: var(--surface); color: var(--ink); }
        html.dark .sultan-nav { background: rgba(20,18,16,0.94); border-bottom-color: rgba(196,154,60,0.22); }
        html.dark .sultan-nav.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,0.4); }
        html.dark .nav-logo { color: #6ee7b7; }
        html.dark .nav-link { color: #a8a29e; }
        html.dark .nav-link:hover { color: #f5f0e8; }
        html.dark .nav-link.active { color: #6ee7b7; }
        html.dark .btn-outline-sm { border-color: rgba(196,154,60,0.45); color: #a7f3d0; }
        html.dark .btn-outline-sm:hover { background: rgba(196,154,60,0.12); border-color: var(--gold); }
        html.dark .btn-filled-sm { background: #0f3d2e; border-color: #0f3d2e; }
        html.dark .nav-icon-btn { border-color: rgba(196,154,60,0.35); }
        html.dark .nav-icon-btn:hover { background: rgba(196,154,60,0.12); }
        html.dark .hero-overlay {
            background: linear-gradient(to bottom,
                rgba(155,58,16,0.52) 0%,
                rgba(26,20,16,0.22) 45%,
                rgba(20,18,16,1) 100%);
        }
        html.dark .pills-bar { background: rgba(20,18,16,0.97); border-bottom-color: rgba(196,154,60,0.14); }
        html.dark .sort-bar { background: rgba(20,18,16,0.97); border-bottom-color: rgba(196,154,60,0.1); box-shadow: 0 2px 12px rgba(0,0,0,0.25); }
        html.dark .sort-select-wrap { background: #2a2824; border-color: rgba(196,154,60,0.3); }
        html.dark .city-pill { border-color: rgba(196,154,60,0.35); color: #a8a29e; }
        html.dark .city-pill:hover { color: var(--ink); }
        html.dark .city-pill.active { background: #0f3d2e; border-color: #0f3d2e; color: #fff; }
        html.dark .rest-card { background: #1c1a17; border-color: rgba(196,154,60,0.18); }
        html.dark .rest-card:hover { box-shadow: 0 28px 56px -10px rgba(0,0,0,0.45); }
        html.dark .card-body, html.dark .card-name { color: var(--ink); }
        html.dark .sk-card { background: #1c1a17; border-color: rgba(196,154,60,0.12); }
        html.dark .sk { background: linear-gradient(90deg, #2a2620 25%, #36322c 50%, #2a2620 75%); }
        html.dark .sultan-footer { background: #1a1815; border-top-color: rgba(196,154,60,0.15); }
        html.dark .footer-logo { color: #6ee7b7; }
        html.dark ::-webkit-scrollbar-track { background: var(--sand); }
    </style>
</head>

<body>

    {{-- ════════════════ NAV ════════════════ --}}
    <nav class="sultan-nav" id="main-nav">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">Sul<span>t</span>an</a>

            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
                <a href="{{ url('/') }}#destinations" class="nav-link">Explore</a>
                <a href="{{ route('map.index') }}" class="nav-link">Map</a>
                <a href="{{ route('restaurants.index') }}" class="nav-link active">Restaurants</a>
                <a href="{{ route('hotels.index') }}" class="nav-link">Hotels</a>
                <a href="{{ url('/') }}#experiences" class="nav-link">Experiences</a>
            </div>

            <div class="nav-actions">
                @auth
                <span style="font-size:0.75rem;color:var(--muted);max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    Hi, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('profile', Auth::id()) }}" class="btn-outline-sm">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-outline-sm" style="cursor:pointer;">Log out</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn-outline-sm">Log in</a>
                <a href="{{ route('signup') }}" class="btn-filled-sm">Sign up</a>
                @endauth
                <x-theme-toggle class="!h-[38px] !w-[38px] !rounded-full !border !border-amber-600/30 !bg-transparent !text-amber-800 hover:!bg-amber-100/20 dark:!border-amber-400/30 dark:!text-amber-200 dark:hover:!bg-white/10" />
                <button class="nav-icon-btn" aria-label="Search" type="button">
                    <span class="material-symbols-outlined" style="font-size:18px;color:var(--teal-dark);">search</span>
                </button>
                <a href="{{ auth()->check() ? route('profile', auth()->id()) : route('login') }}"
                    class="nav-icon-btn" aria-label="Account">
                    <span class="material-symbols-outlined" style="font-size:18px;color:var(--teal-dark);">account_circle</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- ════════════════ HERO ════════════════ --}}
    <header class="hero-section">
        <img class="hero-img"
            src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1600&q=85&auto=format&fit=crop"
            alt="Moroccan restaurant ambiance"
            fetchpriority="high" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-eyebrow hero-line">Morocco · Culinary Treasures</div>
            <h1 class="hero-title hero-line">
                Restaurants<br /><em>in Morocco</em>
            </h1>
            <p class="hero-sub hero-line">From spiced medina tagines to elegant rooftop dining — Morocco's finest tables await.</p>
            <div class="hero-stats hero-line">
                <div class="hero-stat">
                    <span class="hero-stat-num">{{ $total }}</span>
                    <span class="hero-stat-lbl">Curated Spots</span>
                </div>
                <div class="hero-stat" style="border-left:1px solid rgba(255,255,255,0.2);padding-left:2rem;">
                    <span class="hero-stat-num">{{ count($cities) }}</span>
                    <span class="hero-stat-lbl">Cities</span>
                </div>
                <div class="hero-stat" style="border-left:1px solid rgba(255,255,255,0.2);padding-left:2rem;">
                    <span class="hero-stat-num">4.6★</span>
                    <span class="hero-stat-lbl">Avg. Rating</span>
                </div>
            </div>
        </div>
    </header>

    {{-- ════════════════ CITY PILLS ════════════════ --}}
    <div class="pills-bar">
        <div class="pills-inner no-scrollbar" id="city-pills" role="tablist" aria-label="Filter by city">
            {{-- JS injected --}}
        </div>
    </div>

    {{-- ════════════════ SORT BAR ════════════════ --}}
    <div class="sort-bar">
        <div class="sort-inner">
            <div class="sort-select-wrap">
                <span class="material-symbols-outlined" style="font-size:16px;color:var(--gold);">sort</span>
                <select id="sort-sel">
                    <option value="rating">Top Rated</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                </select>
            </div>
            <span id="result-count" class="result-count">Loading restaurants…</span>
        </div>
    </div>

    {{-- ════════════════ MAIN ════════════════ --}}
    <main>
        <div class="section-header">
            <div class="ornament-line">
                <div class="ornament-diamond"></div>
            </div>
            <div class="section-eyebrow">Curated Dining</div>
            <h2 class="section-title">Find Your Perfect Table</h2>
        </div>

        <div id="grid" role="list"></div>

        <div class="load-more-wrap">
            <p id="page-info"></p>
        </div>
    </main>

    {{-- ════════════════ FOOTER ════════════════ --}}
    <footer class="sultan-footer">
        <div class="footer-logo">Sul<span>t</span>an</div>
        <p class="footer-credit">
            Restaurant data curated from <a href="https://www.tripadvisor.com" target="_blank" rel="noopener">TripAdvisor</a>
            &nbsp;·&nbsp;
            <a href="https://nominatim.openstreetmap.org" target="_blank" rel="noopener">OpenStreetMap / Nominatim</a>
            <br />Discover the best of Moroccan cuisine
        </p>
    </footer>

    {{-- ════════════════ JS ════════════════ --}}
    <script>
        var API_BASE = '/api/restaurants';
        var restaurants = [],
            filtered = [],
            favorites = {};
        var cityFilter = 'all',
            sortBy = 'rating';

        var grid = document.getElementById('grid');
        var pillsEl = document.getElementById('city-pills');
        var sortEl = document.getElementById('sort-sel');
        var countEl = document.getElementById('result-count');
        var pageInfo = document.getElementById('page-info');

        /* Nav scroll shadow */
        window.addEventListener('scroll', function() {
            document.getElementById('main-nav').classList.toggle('scrolled', window.scrollY > 20);
        }, { passive: true });

        /* Helpers */
        function esc(s) {
            return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

        function ratingLabel(r) {
            if (r >= 4.8) return 'Exceptional';
            if (r >= 4.6) return 'Excellent';
            if (r >= 4.4) return 'Very Good';
            if (r >= 4.0) return 'Good';
            return 'Reviewed';
        }

        function ratingBg(r) {
            if (r >= 4.8) return '#0d3d30';
            if (r >= 4.6) return '#1a5e47';
            if (r >= 4.4) return '#0d6e6e';
            if (r >= 4.0) return '#7a5200';
            return '#8a7d6b';
        }

        function cuisineBadgeBg(cuisine) {
            var c = (cuisine || '').toLowerCase();
            if (c.includes('french')) return 'rgba(30,58,138,0.82)';
            if (c.includes('mediterranean')) return 'rgba(13,61,48,0.85)';
            if (c.includes('contemporary')) return 'rgba(91,33,182,0.82)';
            if (c.includes('international')) return 'rgba(60,60,60,0.85)';
            return 'rgba(155,58,16,0.82)'; // default: spice/moroccan
        }

        /* Card HTML */
        function cardHTML(r, animDelay) {
            var cardId = 'card-' + r.name.replace(/[^a-z0-9]/gi, '-').toLowerCase();
            var mapsUrl = 'https://maps.google.com/?q=' + r.geo.latitude + ',' + r.geo.longitude;
            var rating = r.review_summary.rating;
            var isFav = favorites[r.name] ? true : false;
            var hFill = isFav ? '#e11d48' : 'none';
            var hStroke = isFav ? '#e11d48' : '#8a7d6b';

            var imgHTML = r.image
                ? '<img src="' + esc(r.image) + '" alt="' + esc(r.name) + '" loading="lazy" class="card-img" onerror="this.parentElement.innerHTML=\'<div style=\\\"background:#f0ede5;height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;\\\">🍽</div>\'" />'
                : '<div style="background:#f0ede5;height:100%;display:flex;align-items:center;justify-content:center;font-size:3.5rem;">🍽</div>';

            var specialtiesHTML = '';
            (r.specialties || []).forEach(function(s) {
                specialtiesHTML += '<span class="specialty-chip">🍴 ' + esc(s) + '</span>';
            });

            var labelsHTML = '';
            (r.labels || []).forEach(function(l) {
                labelsHTML += '<span class="card-label">✓ ' + esc(l) + '</span>';
            });

            return (
                '<article class="rest-card card-animate" id="' + cardId + '" role="listitem"' +
                ' style="animation-delay:' + animDelay + 'ms;">' +

                '<div class="card-img-wrap">' +
                imgHTML +
                '<div class="card-img-overlay"></div>' +
                '<button class="heart-btn" data-key="' + esc(r.name) + '" aria-label="Save" type="button">' +
                '<svg width="16" height="16" viewBox="0 0 24 24" fill="' + hFill + '" stroke="' + hStroke + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
                '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>' +
                '</svg>' +
                '</button>' +
                '<span class="cuisine-badge" style="background:' + cuisineBadgeBg(r.cuisine) + ';">' +
                esc(r.cuisine) +
                '</span>' +
                '<span class="price-pill">' + esc(r.price_level) + '</span>' +
                '</div>' +

                '<div class="card-body">' +
                '<h3 class="card-name">' + esc(r.name) + '</h3>' +
                '<p class="card-city">' +
                '<span class="material-symbols-outlined">location_on</span>' +
                esc(r.city) + ', Morocco' +
                '</p>' +
                '<div class="card-rating-row">' +
                '<span class="rating-score" style="background:' + ratingBg(rating) + ';">' + rating.toFixed(1) + '</span>' +
                '<span class="rating-label">' + ratingLabel(rating) + '</span>' +
                '<span class="rating-count">· ' + r.review_summary.count.toLocaleString() + ' reviews</span>' +
                '</div>' +
                (specialtiesHTML ? '<div class="card-specialties">' + specialtiesHTML + '</div>' : '') +
                (labelsHTML ? '<div class="card-labels">' + labelsHTML + '</div>' : '') +
                '</div>' +

                '<div class="card-footer">' +
                '<span class="card-price-display">' + esc(r.price_level) + '</span>' +
                '<a href="' + esc(mapsUrl) + '" target="_blank" rel="noopener" class="card-map-link">' +
                '<span class="material-symbols-outlined">map</span>Directions' +
                '</a>' +
                '<a href="' + esc(r.tripadvisor_url) + '" target="_blank" rel="noopener" class="card-cta">View ↗</a>' +
                '</div>' +

                '</article>'
            );
        }

        /* Skeletons */
        function showSkeletons(n) {
            var sk = '';
            for (var i = 0; i < n; i++) {
                sk +=
                    '<div class="sk-card">' +
                    '<div class="sk" style="height:200px;border-radius:0;"></div>' +
                    '<div style="padding:1rem 1.1rem;display:flex;flex-direction:column;gap:9px;">' +
                    '<div class="sk" style="height:18px;width:80%;"></div>' +
                    '<div class="sk" style="height:12px;width:45%;"></div>' +
                    '<div style="display:flex;gap:8px;align-items:center;">' +
                    '<div class="sk" style="height:24px;width:36px;border-radius:8px;"></div>' +
                    '<div class="sk" style="height:12px;width:55%;"></div>' +
                    '</div>' +
                    '<div style="display:flex;gap:6px;">' +
                    '<div class="sk" style="height:20px;width:70px;border-radius:100px;"></div>' +
                    '<div class="sk" style="height:20px;width:80px;border-radius:100px;"></div>' +
                    '</div>' +
                    '</div>' +
                    '<div style="border-top:1px solid rgba(196,154,60,0.08);padding:0.7rem 1.1rem;display:flex;justify-content:space-between;gap:8px;">' +
                    '<div class="sk" style="height:22px;width:30px;border-radius:8px;"></div>' +
                    '<div class="sk" style="height:22px;width:70px;border-radius:20px;"></div>' +
                    '<div class="sk" style="height:22px;width:52px;border-radius:20px;"></div>' +
                    '</div>' +
                    '</div>';
            }
            grid.innerHTML = sk;
        }

        /* Count */
        function updateCount() {
            countEl.innerHTML = '';
            var span = document.createElement('span');
            span.className = 'count-animate';
            span.innerHTML = 'Showing <strong>' + filtered.length + '</strong> restaurants';
            countEl.appendChild(span);
        }

        /* City pills */
        function buildPills(list) {
            var seen = {}, cities = ['all'];
            list.forEach(function(r) {
                if (!seen[r.city]) { seen[r.city] = true; cities.push(r.city); }
            });
            cities.sort(function(a, b) { return a === 'all' ? -1 : b === 'all' ? 1 : a.localeCompare(b); });
            pillsEl.innerHTML = '';
            cities.forEach(function(c, i) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'city-pill pill-animate';
                btn.style.animationDelay = (i * 40) + 'ms';
                btn.dataset.city = c;
                btn.textContent = c === 'all' ? '✦  All Cities' : c;
                btn.setAttribute('role', 'tab');
                btn.setAttribute('aria-selected', c === cityFilter ? 'true' : 'false');
                if (c === cityFilter) btn.classList.add('active');
                btn.addEventListener('click', function() {
                    cityFilter = c;
                    document.querySelectorAll('.city-pill').forEach(function(p) {
                        p.classList.toggle('active', p.dataset.city === c);
                        p.setAttribute('aria-selected', p.dataset.city === c ? 'true' : 'false');
                    });
                    animateGridChange(function() { applyFilter(); });
                });
                pillsEl.appendChild(btn);
            });
        }

        /* Grid transition */
        function animateGridChange(cb) {
            grid.classList.add('grid-fade-out');
            setTimeout(function() {
                cb();
                grid.classList.remove('grid-fade-out');
                grid.classList.add('grid-fade-in');
                setTimeout(function() { grid.classList.remove('grid-fade-in'); }, 350);
            }, 200);
        }

        /* Filter */
        function applyFilter() {
            filtered = cityFilter === 'all'
                ? restaurants.slice()
                : restaurants.filter(function(r) { return r.city === cityFilter; });
            renderCards(filtered);
        }

        /* Render */
        function renderCards(list) {
            grid.innerHTML = '';
            if (!list.length) {
                grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:6rem 2rem;">' +
                    '<span class="material-symbols-outlined" style="font-size:4rem;color:#d5ccc0;display:block;margin-bottom:1rem;">restaurant</span>' +
                    '<p style="color:var(--muted);font-size:0.9rem;">No restaurants found for this city.</p>' +
                    '</div>';
                updateCount();
                return;
            }
            var frag = document.createDocumentFragment();
            list.forEach(function(r, idx) {
                var wrap = document.createElement('div');
                wrap.innerHTML = cardHTML(r, idx * 60);
                frag.appendChild(wrap.firstElementChild);
            });
            grid.appendChild(frag);
            bindHeartButtons();
            updateCount();
            pageInfo.textContent = list.length + ' of ' + restaurants.length + ' restaurants displayed ✦';
        }

        /* Hearts */
        function bindHeartButtons() {
            document.querySelectorAll('.heart-btn').forEach(function(btn) {
                if (btn._bound) return;
                btn._bound = true;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var key = btn.dataset.key;
                    favorites[key] = !favorites[key];
                    var svg = btn.querySelector('svg'), isFav = favorites[key];
                    svg.setAttribute('fill', isFav ? '#e11d48' : 'none');
                    svg.setAttribute('stroke', isFav ? '#e11d48' : '#8a7d6b');
                    btn.classList.remove('heart-pop');
                    void btn.offsetWidth;
                    btn.classList.add('heart-pop');
                });
            });
        }

        /* Fetch */
        function loadRestaurants() {
            showSkeletons(9);
            countEl.textContent = 'Loading restaurants…';

            fetch(API_BASE + '?sort=' + sortBy + (cityFilter !== 'all' ? '&city=' + encodeURIComponent(cityFilter) : ''))
                .then(function(res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function(data) {
                    if (data.error) throw new Error(data.error);
                    var list = data.result.list;
                    restaurants = list;
                    buildPills(list);
                    filtered = cityFilter === 'all' ? list.slice() : list.filter(function(r) { return r.city === cityFilter; });
                    renderCards(filtered);
                })
                .catch(function(err) {
                    grid.innerHTML =
                        '<div style="grid-column:1/-1;border:1px solid rgba(184,92,56,0.2);background:rgba(184,92,56,0.04);border-radius:16px;padding:5rem 2rem;text-align:center;">' +
                        '<span class="material-symbols-outlined" style="font-size:3.5rem;color:#b85c38;display:block;margin-bottom:1rem;">warning</span>' +
                        '<h3 style="font-family:Cormorant Garamond,serif;font-size:1.5rem;margin-bottom:0.5rem;">Could not load restaurants</h3>' +
                        '<p style="color:var(--muted);font-size:0.85rem;margin-bottom:2rem;">' + esc(err.message) + '</p>' +
                        '<button onclick="loadRestaurants()" style="background:var(--teal-dark);color:#fff;border:none;border-radius:100px;padding:0.75rem 2rem;font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;cursor:pointer;">Try Again</button>' +
                        '</div>';
                    console.error('[Restaurants]', err);
                });
        }

        /* Events */
        sortEl.addEventListener('change', function() {
            sortBy = sortEl.value;
            animateGridChange(function() { loadRestaurants(); });
        });

        /* Init */
        loadRestaurants();
    </script>
    <x-chatbot />
</body>

</html>
