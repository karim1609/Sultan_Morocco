@props([
    'variant' => 'default',
])

@php
    $isChat = $variant === 'chat';

    $primaryNav = [
        [
            'url' => url('/'),
            'label' => 'Home',
            'active' => request()->is('/'),
        ],
        [
            'url' => route('map.index'),
            'label' => 'Map',
            'active' => request()->routeIs('map.index'),
        ],
        [
            'url' => route('hotels.index'),
            'label' => 'Hotels',
            'active' => request()->routeIs('hotels.index'),
        ],
    ];

    $linkBase = 'nav-master__link rounded-xl';
    $linkDefault = $linkBase .
        ' text-stone-700 hover:bg-stone-100/90 hover:text-stone-900 dark:text-zinc-300 dark:hover:bg-white/10 dark:hover:text-white';
    $linkChat = $linkBase . ' text-zinc-300 hover:bg-white/10 hover:text-white';
    $linkActiveDefault = 'nav-master__link--active text-stone-900 dark:text-white';
    $linkActiveChat = 'nav-master__link--active text-white';

    $panelLinkDefault =
        'nav-master__panel-link text-stone-800 hover:bg-stone-100 dark:text-zinc-100 dark:hover:bg-white/10';
    $panelLinkChat = 'nav-master__panel-link text-zinc-100 hover:bg-white/10';

    $btnGhostDefault =
        'inline-flex items-center justify-center rounded-xl border border-stone-200/90 bg-white/90 px-3.5 py-2 text-sm font-semibold text-stone-800 shadow-sm transition duration-300 hover:scale-[1.02] hover:border-stone-300 hover:bg-stone-50 hover:shadow active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40 focus-visible:ring-offset-2 dark:border-white/15 dark:bg-white/10 dark:text-zinc-100 dark:hover:bg-white/15 dark:focus-visible:ring-cyan-400/50 dark:focus-visible:ring-offset-zinc-950';
    $btnGhostChat =
        'inline-flex items-center justify-center rounded-xl border border-white/15 bg-white/10 px-3.5 py-2 text-sm font-semibold text-zinc-100 transition duration-300 hover:scale-[1.02] hover:bg-white/15 hover:shadow-lg hover:shadow-black/20 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/50 focus-visible:ring-offset-2 focus-visible:ring-offset-zinc-950';

    $btnPrimary =
        'inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-400 via-emerald-400 to-violet-400 px-3.5 py-2 text-sm font-semibold text-zinc-950 shadow-[0_8px_28px_rgba(34,211,238,0.22)] transition duration-300 hover:scale-[1.03] hover:brightness-110 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 focus-visible:ring-offset-2 focus-visible:ring-offset-zinc-950';
@endphp

<header
    data-master-nav
    @class([
        'nav-master sticky top-0 z-50 backdrop-blur-2xl',
        'nav-master--default border-b border-stone-200/70 bg-white/85 shadow-sm dark:border-white/10 dark:bg-zinc-950/80 dark:shadow-[0_1px_0_rgba(255,255,255,0.05)]' => ! $isChat,
        'nav-master--chat border-b border-white/10 bg-zinc-950/85' => $isChat,
    ])
>
    <div
        class="pointer-events-none absolute inset-0 -z-10 opacity-40 dark:opacity-30"
        aria-hidden="true"
    >
        <div
            class="absolute -left-[20%] top-0 h-32 w-[50%] rounded-full bg-gradient-to-r from-cyan-400/25 via-transparent to-transparent blur-3xl dark:from-cyan-500/15"
        ></div>
        <div
            class="absolute -right-[10%] top-0 h-28 w-[45%] rounded-full bg-gradient-to-l from-violet-500/20 via-transparent to-transparent blur-3xl dark:from-violet-500/12"
        ></div>
    </div>

    <div
        class="nav-master__inner relative mx-auto flex w-full max-w-7xl items-center justify-between gap-3 px-4 py-3.5 sm:gap-4 sm:px-6 sm:py-4"
    >
        {{-- Brand --}}
        <div class="flex min-w-0 shrink-0 items-center gap-3">
            <button
                type="button"
                class="nav-master__burger group relative flex h-11 w-11 shrink-0 flex-col items-center justify-center gap-1.5 rounded-2xl border transition duration-300 lg:hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/50 focus-visible:ring-offset-2 focus-visible:ring-offset-transparent @if ($isChat) border-white/15 bg-white/5 text-white @else border-stone-200/90 bg-stone-50/90 text-stone-800 dark:border-white/15 dark:bg-white/10 dark:text-zinc-100 @endif"
                data-nav-toggle
                aria-expanded="false"
                aria-controls="master-nav-panel"
                aria-label="Open menu"
            >
                <span
                    class="nav-master__burger-line w-5 @if ($isChat) bg-zinc-200 @else bg-stone-700 dark:bg-zinc-200 @endif"
                ></span>
                <span
                    class="nav-master__burger-line w-5 @if ($isChat) bg-zinc-200 @else bg-stone-700 dark:bg-zinc-200 @endif"
                ></span>
                <span
                    class="nav-master__burger-line w-5 @if ($isChat) bg-zinc-200 @else bg-stone-700 dark:bg-zinc-200 @endif"
                ></span>
            </button>

            <a href="{{ url('/') }}" class="group inline-flex min-w-0 items-center gap-2.5 sm:gap-3">
                <span
                    class="nav-master__brand-mark relative grid h-10 w-10 shrink-0 place-items-center rounded-2xl border shadow-md transition duration-500 group-hover:rotate-6 group-hover:scale-105 sm:h-11 sm:w-11 @if ($isChat) border-white/15 bg-white/5 @else border-stone-200/90 bg-stone-50 dark:border-white/10 dark:bg-white/5 @endif"
                >
                    <span
                        class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-br from-cyan-400/30 via-emerald-400/15 to-violet-500/25 opacity-0 transition duration-500 group-hover:opacity-100"
                    ></span>
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt=""
                        class="relative h-5 w-5 object-contain opacity-90 transition duration-300 group-hover:opacity-100 sm:h-6 sm:w-6"
                    />
                </span>
                <div class="min-w-0 leading-tight">
                    <div
                        class="truncate text-sm font-bold tracking-tight sm:text-base @if ($isChat) text-white @else text-stone-900 dark:text-white @endif"
                    >
                        Sultan Morocco
                    </div>
                    <div
                        class="hidden text-[0.65rem] font-medium uppercase tracking-[0.2em] sm:block @if ($isChat) text-zinc-500 @else text-stone-500 dark:text-zinc-500 @endif"
                    >
                        Discover · Plan · Go
                    </div>
                </div>
            </a>
        </div>

        {{-- Desktop primary nav (flexible center) --}}
        <nav
            class="hidden flex-1 items-center justify-center gap-0.5 px-4 lg:flex xl:gap-1"
            aria-label="Primary"
        >
            @foreach ($primaryNav as $item)
                <a
                    href="{{ $item['url'] }}"
                    @class([
                        $isChat ? $linkChat : $linkDefault,
                        'nav-master__link--chat' => $isChat,
                        $linkActiveChat => $isChat && $item['active'],
                        $linkActiveDefault => ! $isChat && $item['active'],
                    ])
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            @auth
                <a
                    href="{{ route('messages.index') }}"
                    @class([
                        $isChat ? $linkChat : $linkDefault,
                        'nav-master__link--chat' => $isChat,
                        $linkActiveChat => $isChat && request()->routeIs('messages.*'),
                        $linkActiveDefault => ! $isChat && request()->routeIs('messages.*'),
                    ])
                >
                    Messages
                </a>
            @endauth

            {{ $extraNav ?? '' }}
        </nav>

        {{-- Actions --}}
        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
            {{ $beforeActions ?? '' }}

            @if ($isChat)
                <x-theme-toggle
                    class="!h-10 !w-10 !rounded-xl !border-white/15 !bg-white/10 !text-zinc-100 hover:!scale-105 hover:!bg-white/15"
                />
            @else
                <x-theme-toggle
                    class="!h-10 !w-10 !rounded-xl transition-transform duration-300 hover:!scale-105"
                />
            @endif

            @auth
                <a
                    href="{{ route('profile', auth()->id()) }}"
                    class="{{ $isChat ? $btnGhostChat : $btnGhostDefault }} hidden sm:inline-flex"
                >
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                    @csrf
                    <button type="submit" class="{{ $btnPrimary }}">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ $isChat ? $btnGhostChat : $btnGhostDefault }} hidden sm:inline-flex">
                    Log in
                </a>
                <a href="{{ route('signup') }}" class="{{ $btnPrimary }} hidden sm:inline-flex">
                    Sign up
                </a>
            @endauth

            {{ $actions ?? '' }}
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div
        id="master-nav-panel"
        class="nav-master__panel overflow-hidden border-t lg:hidden @if ($isChat) border-white/10 bg-zinc-950/95 @else border-stone-200/70 bg-white/95 dark:border-white/10 dark:bg-zinc-950/95 @endif"
        data-nav-panel
        data-open="false"
        aria-hidden="true"
    >
        <nav class="flex flex-col gap-1 px-4 pb-6 pt-2" aria-label="Mobile primary">
            @foreach ($primaryNav as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="{{ $isChat ? $panelLinkChat : $panelLinkDefault }} {{ $item['active'] ? ($isChat ? 'bg-white/10 text-white' : 'bg-stone-100 text-stone-900 dark:bg-white/10 dark:text-white') : '' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            @auth
                <a
                    href="{{ route('messages.index') }}"
                    class="{{ $isChat ? $panelLinkChat : $panelLinkDefault }} {{ request()->routeIs('messages.*') ? ($isChat ? 'bg-white/10 text-white' : 'bg-stone-100 dark:bg-white/10') : '' }}"
                >
                    Messages
                </a>
                <a
                    href="{{ route('profile', auth()->id()) }}"
                    class="{{ $isChat ? $panelLinkChat : $panelLinkDefault }}"
                >
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2 px-4">
                    @csrf
                    <button type="submit" class="{{ $btnPrimary }} w-full py-3">
                        Log out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ $isChat ? $panelLinkChat : $panelLinkDefault }}">
                    Log in
                </a>
                <a
                    href="{{ route('signup') }}"
                    class="{{ $isChat ? $panelLinkChat : $panelLinkDefault }} justify-center bg-gradient-to-r from-cyan-400/20 via-emerald-400/15 to-violet-400/20 font-bold text-stone-900 dark:text-white"
                >
                    Sign up
                </a>
            @endauth

            {{ $mobileExtra ?? '' }}
        </nav>
    </div>
</header>
