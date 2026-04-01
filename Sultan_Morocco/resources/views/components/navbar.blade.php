<header class="sticky top-0 z-40 border-b border-white/10 bg-zinc-950/70 backdrop-blur-xl">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ url('/') }}" class="group inline-flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-2xl border border-white/10 bg-white/5 shadow-sm">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo"
                    class="h-6 w-6 object-contain opacity-90 group-hover:opacity-100 transition"
                />
            </span>
            <div class="leading-tight">
                <div class="text-sm font-semibold tracking-tight">Sultan Morocco</div>
                <div class="text-xs text-zinc-400">Ultra Tailwind UI</div>
            </div>
        </a>

        <nav class="flex items-center gap-2">
            <a class="btn-ghost" href="{{ route('profile', auth()->id()) }}">Profile</a>
            <a class="btn-primary" href="{{ route('logout') }}">Logout</a>
        </nav>
    </div>
</header>