@php
    $initials = \Illuminate\Support\Str::upper(
        \Illuminate\Support\Str::substr($user->name, 0, 1) .
            (\Illuminate\Support\Str::contains($user->name, ' ') ? \Illuminate\Support\Str::substr(\Illuminate\Support\Str::afterLast($user->name, ' '), 0, 1) : '')
    );
    $avatarUrl = null;
    if (! empty($user->avatar)) {
        $avatarUrl = \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://'])
            ? $user->avatar
            : \Illuminate\Support\Facades\Storage::disk('public')->url($user->avatar);
    }
@endphp

<x-layouts.app title="Profile — {{ $user->name }} · {{ config('app.name', 'Sultan Morocco') }}">
    <div class="profile-page relative space-y-10 pb-16">

        {{-- Ambient background blobs --}}
        <div class="pointer-events-none fixed inset-0 -z-20 overflow-hidden">
            <div class="absolute h-[3px] w-[3px] bg-white rounded-full animate-bounce opacity-30 top-1/3 left-1/4"></div>
            <div class="absolute h-[3px] w-[3px] bg-cyan-300 rounded-full animate-bounce delay-200 opacity-40 top-2/3 left-2/4"></div>
            <div class="profile-ambient-1 absolute -left-[20%] top-[10%] h-[min(520px,80vw)] w-[min(520px,80vw)] rounded-full bg-gradient-to-br from-cyan-400/25 via-emerald-400/15 to-transparent blur-3xl dark:from-cyan-500/12 dark:via-emerald-500/8"></div>
            <div class="profile-ambient-2 absolute -right-[15%] top-[35%] h-[min(420px,70vw)] w-[min(420px,70vw)] rounded-full bg-gradient-to-bl from-violet-500/20 via-fuchsia-500/10 to-transparent blur-3xl dark:from-violet-500/10"></div>
            <div class="profile-ambient-3 absolute bottom-[5%] left-[30%] h-[min(360px,55vw)] w-[min(360px,55vw)] rounded-full bg-gradient-to-tr from-amber-400/15 to-emerald-500/10 blur-3xl dark:from-amber-500/8"></div>
        </div>

        {{-- Hero --}}
        <header class="profile-hero-in relative overflow-hidden rounded-[2rem] border border-stone-200/80 bg-gradient-to-br from-white/95 via-stone-50/90 to-emerald-50/50 p-6 shadow-lg shadow-stone-200/40 ring-1 ring-white/60 backdrop-blur-xl dark:border-white/10 dark:from-zinc-900/95 dark:via-zinc-900/85 dark:to-emerald-950/50 dark:shadow-[0_32px_100px_rgba(0,0,0,0.45)] dark:ring-white/5 sm:p-10">
            
            <div class="pointer-events-none absolute inset-0 opacity-40 dark:opacity-30">
                <div class="absolute -right-12 -top-12 h-56 w-56 rounded-full bg-gradient-to-br from-cyan-300/50 to-violet-400/40 blur-2xl dark:from-cyan-500/20 dark:to-violet-500/20"></div>
                <div class="absolute -bottom-8 left-1/4 h-40 w-40 rounded-full bg-emerald-400/30 blur-2xl dark:bg-emerald-500/15"></div>
            </div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 flex-col items-center gap-6 sm:flex-row sm:items-center sm:gap-8">
                    
                    {{-- Avatar + animated ring --}}
                    <div class="relative shrink-0">
                        <div class="profile-avatar-spin absolute -inset-[3px] rounded-[1.4rem] bg-gradient-to-br from-cyan-400 via-emerald-400 to-violet-500 opacity-95 dark:opacity-90 animate-spin-slow"></div>
                        <div class="profile-avatar-glow pointer-events-none absolute -inset-3 rounded-[1.6rem] bg-gradient-to-r from-cyan-400/35 via-emerald-400/25 to-violet-500/35 blur-lg dark:from-cyan-500/25 dark:via-emerald-500/15 dark:to-violet-500/25"></div>
                        <div class="relative grid h-28 w-28 place-items-center overflow-hidden rounded-3xl border border-white/80 bg-white shadow-xl dark:border-white/10 dark:bg-zinc-900/90 sm:h-32 sm:w-32">
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"/>
                            @else
                                <span class="profile-initials select-none text-3xl font-bold sm:text-4xl">{{ $initials }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Name & email --}}
                    <div class="min-w-0 text-center sm:text-left">
                        <p class="animate-pulse text-xs font-semibold uppercase tracking-[0.28em] text-emerald-700/90 dark:text-emerald-400/90">Your space</p>
                        <h1 class="welcome-shimmer mt-2 font-sans text-3xl font-semibold tracking-tight sm:text-4xl md:text-5xl">{{ $user->name }}</h1>
                        <p class="mt-3 max-w-md truncate text-sm text-stone-600 dark:text-zinc-400 sm:text-base">{{ $user->email }}</p>
                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2 sm:justify-start">
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/80 bg-emerald-50/90 px-3 py-1 text-xs font-medium text-emerald-900 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-500 opacity-60"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                </span>
                                Active curator
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="profile-stagger flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col lg:items-end">
                    <a href="{{ url('/') }}" class="profile-card inline-flex items-center justify-center rounded-full border border-stone-200/90 bg-white px-6 py-3 text-sm font-semibold text-stone-800 shadow-md transition-transform duration-200 hover:scale-105 dark:border-white/15 dark:bg-white/10 dark:text-zinc-100 dark:shadow-none">
                        <svg class="mr-2 h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('map.index') }}" class="btn-primary inline-flex px-6 py-3 shadow-lg transition-transform duration-200 hover:scale-105">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Explore map
                    </a>
                    <a href="{{ route('hotels.index') }}" class="profile-card inline-flex items-center justify-center rounded-full border border-stone-200/80 bg-stone-50/90 px-6 py-3 text-sm font-semibold text-stone-800 transition-transform duration-200 hover:scale-105 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200">
                        Hotels
                    </a>
                    @auth
                        @if (auth()->id() !== $user->id)
                            <a
                                href="{{ route('messages.show', $user) }}"
                                class="profile-card inline-flex items-center justify-center rounded-full border border-cyan-200/80 bg-cyan-50/90 px-6 py-3 text-sm font-semibold text-cyan-950 transition-transform duration-200 hover:scale-105 dark:border-cyan-500/30 dark:bg-cyan-500/10 dark:text-cyan-100"
                            >
                                Message
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        {{-- Detail cards --}}
        <section>
            <h2 class="mb-6 flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-stone-500 dark:text-zinc-500">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent via-stone-300 to-transparent dark:via-white/20"></span>
                <span>Profile details</span>
                <span class="h-px flex-1 bg-gradient-to-r from-transparent via-stone-300 to-transparent dark:via-white/20"></span>
            </h2>

            <div class="profile-stagger grid gap-4 sm:grid-cols-2">
                @foreach([
                    ['icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','color'=>'emerald','label'=>'Full name','value'=>$user->name],
                    ['icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','color'=>'cyan','label'=>'Email','value'=>$user->email],
                    ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','color'=>'violet','label'=>'Role','value'=>$user->role ?? '—'],
                    ['icon'=>'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'amber','label'=>'Country','value'=>$user->country ?? '—'],
                ] as $detail)
                <div class="profile-card group relative overflow-hidden rounded-2xl border border-stone-200/80 bg-white/90 p-5 shadow-md transition-transform duration-200 hover:-translate-y-2 hover:shadow-xl dark:border-white/10 dark:bg-white/[0.07] dark:shadow-[0_16px_50px_rgba(0,0,0,0.25)]">
                    <div class="mb-3 flex items-center gap-2 text-stone-500 dark:text-zinc-400">
                        <div class="h-8 w-8 flex items-center justify-center rounded-full bg-{{ $detail['color'] }}-100 dark:bg-{{ $detail['color'] }}-900/30 text-{{ $detail['color'] }}-700 dark:text-{{ $detail['color'] }}-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $detail['icon'] }}" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider">{{ $detail['label'] }}</span>
                    </div>
                    <p class="text-lg font-semibold text-stone-900 dark:text-white break-words">{{ $detail['value'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <p class="text-center text-xs text-stone-500 opacity-80 dark:text-zinc-500">
            Member ID
            <span class="font-mono font-medium text-stone-700 dark:text-zinc-300">#{{ $user->id }}</span>
            · Sultan Morocco
        </p>
    </div>

    {{-- Tailwind extra animations --}}
    <style>
        @keyframes spin-slow { 0%{ transform: rotate(0deg);} 100%{transform: rotate(360deg);} }
        .animate-spin-slow { animation: spin-slow 12s linear infinite; }
        
        @keyframes gradient-text { 0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;} }
        .profile-initials {
            background: linear-gradient(135deg, #059669, #0d9488, #7c3aed);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradient-text 5s ease infinite;
        }

        .welcome-shimmer { position: relative; overflow: hidden; }
        .welcome-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2.5s infinite;
        }
        @keyframes shimmer { 0%{left:-75%;} 100%{left:125%;} }
    </style>
</x-layouts.app>