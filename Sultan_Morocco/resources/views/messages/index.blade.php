@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app title="Messages · {{ config('app.name', 'Sultan Morocco') }}">
    <div class="space-y-6">
        <header class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500 dark:text-zinc-500">Inbox</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-stone-900 dark:text-white sm:text-3xl">Messages</h1>
                <p class="mt-1 text-sm text-stone-600 dark:text-zinc-400">Chats with other travelers on Sultan Morocco.</p>
            </div>
            <a
                href="{{ route('map.index') }}"
                class="inline-flex items-center justify-center rounded-full border border-stone-200/90 bg-white px-4 py-2 text-sm font-semibold text-stone-800 shadow-sm transition hover:bg-stone-50 dark:border-white/15 dark:bg-white/10 dark:text-zinc-100 dark:hover:bg-white/15"
            >
                Explore map
            </a>
        </header>

        <div
            class="rounded-3xl border border-stone-200/80 bg-white/90 p-4 shadow-sm dark:border-white/10 dark:bg-white/[0.06] sm:p-5"
        >
            <p class="text-sm font-semibold text-stone-800 dark:text-zinc-100">Chat with someone by user ID</p>
            <p class="mt-1 text-xs text-stone-500 dark:text-zinc-500">
                Each member has an ID on their profile (e.g. <span class="font-mono">#12</span>). Enter it to open or continue a conversation.
            </p>
            <form
                method="post"
                action="{{ route('messages.by_user_id') }}"
                class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-end"
            >
                @csrf
                <div class="min-w-0 flex-1">
                    <label for="user_id" class="sr-only">User ID</label>
                    <input
                        id="user_id"
                        name="user_id"
                        type="number"
                        min="1"
                        inputmode="numeric"
                        value="{{ old('user_id') }}"
                        placeholder="e.g. 5"
                        required
                        class="w-full rounded-2xl border border-stone-200/90 bg-white px-4 py-3 text-sm text-stone-900 shadow-sm placeholder:text-stone-400 focus:border-emerald-500/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-white/15 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500"
                    />
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="inline-flex shrink-0 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 via-emerald-400 to-violet-400 px-6 py-3 text-sm font-semibold text-zinc-950 shadow-md transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/50"
                >
                    Open chat
                </button>
            </form>
        </div>

        @if ($conversations->isEmpty())
            <div
                class="rounded-3xl border border-dashed border-stone-300/80 bg-stone-50/50 px-6 py-16 text-center dark:border-white/15 dark:bg-white/[0.03]"
            >
                <p class="text-sm font-medium text-stone-700 dark:text-zinc-300">No conversations yet.</p>
                <p class="mt-2 text-sm text-stone-500 dark:text-zinc-500">Use the form above with their user ID, or open their profile and tap Message.</p>
            </div>
        @else
            <ul class="divide-y divide-stone-200/80 overflow-hidden rounded-3xl border border-stone-200/80 bg-white/90 shadow-sm dark:divide-white/10 dark:border-white/10 dark:bg-white/[0.06]">
                @foreach ($conversations as $conversation)
                    @php
                        $other = $conversation->otherParticipant(auth()->user());
                        $latest = $latestByConversation->get($conversation->id);
                    @endphp
                    @continue(!$other)
                    <li>
                        <a
                            href="{{ route('messages.show', $other) }}"
                            class="flex items-center gap-4 px-4 py-4 transition hover:bg-stone-50/90 dark:hover:bg-white/[0.06] sm:px-5"
                        >
                            <div
                                class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl border border-stone-200/80 bg-gradient-to-br from-cyan-400/20 to-violet-500/20 text-sm font-bold text-stone-800 dark:border-white/10 dark:text-zinc-100"
                            >
                                {{ Str::upper(Str::substr($other->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="truncate font-semibold text-stone-900 dark:text-white">{{ $other->name }}</span>
                                    @if ($conversation->unread_count > 0)
                                        <span
                                            class="shrink-0 rounded-full bg-emerald-500 px-2 py-0.5 text-xs font-semibold text-zinc-950"
                                        >
                                            {{ $conversation->unread_count }}
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-0.5 truncate text-sm text-stone-500 dark:text-zinc-400">
                                    @if ($latest)
                                        <span class="font-medium text-stone-600 dark:text-zinc-300">
                                            {{ $latest->sender_id === auth()->id() ? 'You: ' : '' }}
                                        </span>
                                        {{ Str::limit($latest->body, 80) }}
                                    @elseif ($conversation->last_message_preview)
                                        {{ Str::limit($conversation->last_message_preview, 80) }}
                                    @else
                                        <span class="italic opacity-70">No messages yet</span>
                                    @endif
                                </p>
                            </div>
                            <svg class="h-5 w-5 shrink-0 text-stone-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
