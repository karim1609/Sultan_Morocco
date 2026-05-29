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
    $memberSince = $user->created_at ? $user->created_at->format('M Y') : 'N/A';
    $isOwnProfile = auth()->check() && auth()->id() === $user->id;
@endphp

<x-layouts.app title="Profile — {{ $user->name }} · {{ config('app.name', 'Sultan Morocco') }}">
<div class="pb-20">

    {{-- COVER BANNER --}}
    <div class="relative -mx-4 -mt-8 h-52 overflow-hidden sm:-mx-6 sm:h-64 md:h-72 md:rounded-b-[2.5rem]">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-cyan-500 to-violet-600"></div>
        {{-- Subtle pattern overlay --}}
        <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")"></div>
        {{-- Floating decorative circles --}}
        <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -left-8 bottom-0 h-48 w-48 rounded-full bg-cyan-300/20 blur-2xl"></div>
        <div class="absolute right-1/4 top-1/3 h-32 w-32 rounded-full bg-violet-400/20 blur-xl"></div>
    </div>

    {{-- AVATAR + NAME ROW (overlapping cover) --}}
    <div class="relative -mt-16 px-4 sm:px-6">
        <div class="flex flex-col items-start gap-5 sm:flex-row sm:items-end sm:justify-between">

            {{-- Avatar --}}
            <div class="relative shrink-0">
                {{-- Spinning gradient ring --}}
                <div class="absolute -inset-[3px] rounded-[1.6rem] bg-gradient-to-br from-cyan-400 via-emerald-400 to-violet-500 opacity-95 animate-spin-slow"></div>
                {{-- Glow --}}
                <div class="pointer-events-none absolute -inset-4 rounded-[2rem] bg-gradient-to-r from-cyan-400/30 via-emerald-400/20 to-violet-500/30 blur-lg"></div>
                <div class="relative grid h-28 w-28 place-items-center overflow-hidden rounded-[1.5rem] border-4 border-white bg-white shadow-2xl dark:border-zinc-900 dark:bg-zinc-900 sm:h-32 sm:w-32">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-full w-full object-cover"/>
                    @else
                        <span class="profile-initials select-none text-3xl font-bold sm:text-4xl">{{ $initials }}</span>
                    @endif
                </div>
            </div>

            {{-- Action buttons --}}
            @if (!$isOwnProfile)
            <div class="flex flex-wrap gap-2">
                @auth
                    @if (auth()->id() !== $user->id)
                    <a href="{{ route('messages.show', $user) }}"
                       class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-cyan-500 to-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition hover:brightness-110 hover:scale-105">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Message
                    </a>
                    @endif
                @endauth
            </div>
            @else
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('map.index') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-500 to-cyan-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition hover:brightness-110 hover:scale-105">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Explore Map
                </a>
                <a href="{{ route('hotels.index') }}"
                   class="inline-flex items-center gap-2 rounded-full border border-stone-200 bg-white/90 px-5 py-2.5 text-sm font-semibold text-stone-800 shadow-sm transition hover:scale-105 dark:border-white/15 dark:bg-white/10 dark:text-white">
                    Hotels
                </a>
            </div>
            @endif
        </div>

        {{-- Name & badges --}}
        <div class="mt-4">
            <h1 class="text-2xl font-bold tracking-tight text-stone-900 dark:text-white sm:text-3xl">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-stone-500 dark:text-zinc-400">{{ $user->email }}</p>
            <div class="mt-3 flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/80 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-500 opacity-60"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    Active member
                </span>
                @if($user->role)
                <span class="inline-flex items-center rounded-full border border-violet-200/80 bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-800 dark:border-violet-500/30 dark:bg-violet-500/10 dark:text-violet-300">
                    {{ ucfirst($user->role) }}
                </span>
                @endif
                <span class="inline-flex items-center rounded-full border border-stone-200/80 bg-stone-50 px-3 py-1 text-xs font-medium text-stone-600 dark:border-white/10 dark:bg-white/5 dark:text-zinc-400">
                    Member since {{ $memberSince }}
                </span>
            </div>
        </div>
    </div>

    {{-- STATS ROW --}}
    <div class="mt-8 px-4 sm:px-6">
        <div class="grid grid-cols-3 gap-3 rounded-2xl border border-stone-200/80 bg-white/80 p-4 shadow-sm backdrop-blur-sm dark:border-white/10 dark:bg-white/[0.06] sm:p-6">
            @foreach([
                ['label' => 'Member ID', 'value' => '#' . $user->id, 'color' => 'emerald'],
                ['label' => 'Member Since', 'value' => $memberSince, 'color' => 'cyan'],
                ['label' => 'Status', 'value' => 'Active', 'color' => 'violet'],
            ] as $stat)
            <div class="flex flex-col items-center gap-1 text-center">
                <span class="text-lg font-bold text-stone-900 dark:text-white sm:text-xl">{{ $stat['value'] }}</span>
                <span class="text-xs font-medium text-stone-500 dark:text-zinc-500">{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- PROFILE DETAIL CARDS --}}
    <div class="mt-8 px-4 sm:px-6">
        <h2 class="mb-4 flex items-center gap-3 text-xs font-semibold uppercase tracking-widest text-stone-500 dark:text-zinc-500">
            <span class="h-px flex-1 bg-gradient-to-r from-transparent via-stone-200 to-transparent dark:via-white/15"></span>
            Profile Details
            <span class="h-px flex-1 bg-gradient-to-r from-transparent via-stone-200 to-transparent dark:via-white/15"></span>
        </h2>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach([
                ['icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','color'=>'emerald','label'=>'Full Name','value'=>$user->name],
                ['icon'=>'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z','color'=>'cyan','label'=>'Email Address','value'=>$user->email],
                ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','color'=>'violet','label'=>'Role','value'=>$user->role ?? 'Member'],
                ['icon'=>'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'amber','label'=>'Country','value'=>$user->country ?? 'Morocco'],
            ] as $detail)
            <div class="group relative overflow-hidden rounded-2xl border border-stone-200/80 bg-white/90 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md dark:border-white/10 dark:bg-white/[0.06]">
                <div class="pointer-events-none absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100 bg-gradient-to-br from-{{ $detail['color'] }}-50/50 to-transparent dark:from-{{ $detail['color'] }}-500/5"></div>
                <div class="relative flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-{{ $detail['color'] }}-100 text-{{ $detail['color'] }}-700 dark:bg-{{ $detail['color'] }}-900/30 dark:text-{{ $detail['color'] }}-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $detail['icon'] }}" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[0.7rem] font-semibold uppercase tracking-wider text-stone-500 dark:text-zinc-500">{{ $detail['label'] }}</p>
                        <p class="mt-0.5 text-sm font-semibold text-stone-900 dark:text-white break-all">{{ $detail['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<style>
    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 12s linear infinite; }
    .profile-initials {
        background: linear-gradient(135deg, #059669, #0d9488, #7c3aed);
        background-size: 200%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: gradient-shift 5s ease infinite;
    }
    @keyframes gradient-shift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
</style>
</x-layouts.app>
