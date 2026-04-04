@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.chat title="Chat with {{ $other->name }} · {{ config('app.name', 'Sultan Morocco') }}">
    <div class="mx-auto flex w-full min-w-0 max-w-3xl flex-1 flex-col gap-5">
        {{-- Header --}}
        <div class="flex min-w-0 items-center gap-3">
            <a
                href="{{ route('messages.index') }}"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-zinc-800/80 text-zinc-200 shadow-sm transition hover:bg-zinc-800"
                aria-label="Back to inbox"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="min-w-0 flex-1">
                <h1 class="truncate text-lg font-semibold text-white">{{ $other->name }}</h1>
                <p class="truncate text-xs text-zinc-500">{{ $other->email }}</p>
            </div>
            <a
                href="{{ route('profile', $other->id) }}"
                class="hidden shrink-0 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-zinc-200 transition hover:bg-white/10 sm:inline"
            >
                Profile
            </a>
        </div>

        {{-- Thread: clip + scroll so content stays inside the panel --}}
        <div
            class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/90 shadow-[0_0_0_1px_rgba(255,255,255,0.04),inset_0_1px_0_rgba(255,255,255,0.06)]"
        >
            <div
                id="chat-thread-scroll"
                class="max-h-[min(28rem,50vh)] min-h-[12rem] flex-1 overflow-y-auto overflow-x-hidden overscroll-y-contain px-3 py-4 sm:max-h-[min(34rem,56vh)] sm:px-5 sm:py-5"
            >
                <div class="flex w-full min-w-0 flex-col gap-3">
                    @forelse ($messages as $message)
                        @php $mine = $message->sender_id === auth()->id(); @endphp
                        <div class="flex w-full min-w-0 {{ $mine ? 'justify-end' : 'justify-start' }}">
                            <div
                                class="min-w-0 max-w-[min(100%,20rem)] overflow-hidden rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed shadow-md sm:max-w-[85%] {{ $mine ? 'rounded-br-md bg-gradient-to-br from-emerald-600 to-cyan-700 text-white' : 'rounded-bl-md border border-white/10 bg-zinc-800/90 text-zinc-100' }}"
                            >
                                @unless ($mine)
                                    <p class="mb-1 truncate text-xs font-semibold text-emerald-400">
                                        {{ Str::before($message->sender->name, ' ') }}
                                    </p>
                                @endunless
                                <p
                                    class="whitespace-pre-wrap break-words [overflow-wrap:anywhere] [word-break:break-word]"
                                >
                                    {{ $message->body }}
                                </p>
                                <p class="mt-1.5 text-[0.65rem] opacity-75">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="py-10 text-center text-sm text-zinc-500">No messages yet. Say hello below.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Composer --}}
        <form
            method="post"
            action="{{ route('messages.store', $other) }}"
            class="flex min-w-0 flex-col gap-3 sm:flex-row sm:items-end"
        >
            @csrf
            <div class="min-w-0 flex-1">
                <label for="body" class="sr-only">Message</label>
                <textarea
                    id="body"
                    name="body"
                    rows="3"
                    required
                    maxlength="5000"
                    placeholder="Write a message…"
                    class="w-full min-w-0 resize-y rounded-2xl border border-white/10 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 shadow-inner placeholder:text-zinc-600 focus:border-emerald-500/40 focus:outline-none focus:ring-2 focus:ring-emerald-500/25"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-sm text-red-400">{{ $errors->first('body') }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="inline-flex shrink-0 items-center justify-center rounded-full bg-gradient-to-r from-emerald-500 to-cyan-600 px-6 py-3 text-sm font-semibold text-zinc-950 shadow-lg shadow-emerald-900/30 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/50 sm:h-[3.25rem]"
            >
                Send
            </button>
        </form>
    </div>

    <script>
        (function () {
            var el = document.getElementById('chat-thread-scroll');
            if (el) el.scrollTop = el.scrollHeight;
        })();
    </script>
</x-layouts.chat>
