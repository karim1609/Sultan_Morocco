@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app title="Messages · {{ config('app.name', 'Sultan Morocco') }}">
<div class="mx-auto max-w-2xl space-y-5 pb-12">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-cyan-600 to-violet-600 p-6 shadow-lg">
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-white/70">Inbox</p>
                <h1 class="mt-1 text-2xl font-bold text-white">Messages</h1>
                <p class="mt-1 text-sm text-white/70">Your conversations on Sultan Morocco</p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- New chat form --}}
    <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-5 shadow-sm dark:border-white/10 dark:bg-white/[0.06]">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-cyan-100 dark:bg-cyan-900/30">
                <svg class="h-4 w-4 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-stone-800 dark:text-zinc-100">New conversation</p>
                <p class="text-xs text-stone-500 dark:text-zinc-500">Enter a user's ID to start chatting</p>
            </div>
        </div>
        <form method="post" action="{{ route('messages.by_user_id') }}" class="flex gap-2">
            @csrf
            <input
                id="user_id" name="user_id" type="number" min="1" inputmode="numeric"
                value="{{ old('user_id') }}" placeholder="User ID (e.g. 5)" required
                class="flex-1 rounded-xl border border-stone-200/90 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder:text-stone-400 focus:border-emerald-500/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-white/15 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500"
            />
            <button type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-cyan-500 to-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow transition hover:brightness-110">
                Start chat
            </button>
        </form>
        @error('user_id')
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Conversation list --}}
    @if ($conversations->isEmpty())
        <div class="rounded-2xl border border-dashed border-stone-300/80 bg-stone-50/50 px-6 py-16 text-center dark:border-white/15 dark:bg-white/[0.03]">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-stone-100 dark:bg-white/10">
                <svg class="h-7 w-7 text-stone-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <p class="font-semibold text-stone-700 dark:text-zinc-300">No conversations yet</p>
            <p class="mt-1 text-sm text-stone-500 dark:text-zinc-500">Use the form above to start your first conversation.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white/90 shadow-sm dark:border-white/10 dark:bg-white/[0.06]">
            <div class="border-b border-stone-100 px-5 py-3.5 dark:border-white/10">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500 dark:text-zinc-500">Recent chats</p>
            </div>
            <ul class="divide-y divide-stone-100 dark:divide-white/[0.06]">
                @foreach ($conversations as $conversation)
                    @php
                        $other = $conversation->otherParticipant(auth()->user());
                        $latest = $latestByConversation->get($conversation->id);
                        $initial = $other ? Str::upper(Str::substr($other->name, 0, 1)) : '?';
                    @endphp
                    @continue(!$other)
                    <li>
                        <a href="{{ route('messages.show', $other) }}"
                           class="flex items-center gap-4 px-5 py-4 transition-colors hover:bg-stone-50/80 dark:hover:bg-white/[0.04]">
                            {{-- Avatar --}}
                            <div class="relative shrink-0">
                                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-cyan-400/30 via-emerald-400/20 to-violet-500/30 text-sm font-bold text-stone-800 dark:text-zinc-100 border border-stone-200/60 dark:border-white/10">
                                    {{ $initial }}
                                </div>
                                @if($conversation->unread_count > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-[0.6rem] font-bold text-white shadow-sm">
                                    {{ $conversation->unread_count }}
                                </span>
                                @endif
                            </div>
                            {{-- Content --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex items-baseline justify-between gap-2">
                                    <span class="truncate text-sm font-semibold {{ $conversation->unread_count > 0 ? 'text-stone-900 dark:text-white' : 'text-stone-700 dark:text-zinc-200' }}">
                                        {{ $other->name }}
                                    </span>
                                    @if($latest)
                                    <span class="shrink-0 text-[0.65rem] text-stone-400 dark:text-zinc-600">{{ $latest->created_at->diffForHumans(null, true) }}</span>
                                    @endif
                                </div>
                                <p class="mt-0.5 truncate text-xs {{ $conversation->unread_count > 0 ? 'font-medium text-stone-700 dark:text-zinc-200' : 'text-stone-400 dark:text-zinc-500' }}">
                                    @if ($latest)
                                        {{ $latest->sender_id === auth()->id() ? 'You: ' : '' }}{{ Str::limit($latest->body, 70) }}
                                    @else
                                        <span class="italic">No messages yet</span>
                                    @endif
                                </p>
                            </div>
                            <svg class="h-4 w-4 shrink-0 text-stone-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
</x-layouts.app>
