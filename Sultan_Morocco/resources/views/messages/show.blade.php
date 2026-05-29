@php
    use Illuminate\Support\Str;
    $otherInitial = Str::upper(Str::substr($other->name, 0, 1));
@endphp

<x-layouts.chat title="Chat with {{ $other->name }} · {{ config('app.name', 'Sultan Morocco') }}">
    <div class="mx-auto flex w-full min-w-0 max-w-2xl flex-1 flex-col gap-4">

        {{-- Header --}}
        <div class="flex min-w-0 items-center gap-3 rounded-2xl border border-white/10 bg-zinc-800/60 px-4 py-3 backdrop-blur-sm">
            <a href="{{ route('messages.index') }}"
               class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-zinc-700/80 text-zinc-200 transition hover:bg-zinc-700"
               aria-label="Back">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            {{-- Avatar --}}
            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-cyan-500/40 to-violet-500/40 text-sm font-bold text-white border border-white/10">
                {{ $otherInitial }}
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="truncate text-sm font-semibold text-white">{{ $other->name }}</h1>
                <p class="truncate text-xs text-zinc-500">{{ $other->email }}</p>
            </div>
            <a href="{{ route('profile', $other->id) }}"
               class="hidden shrink-0 rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-zinc-300 transition hover:bg-white/10 sm:inline-flex items-center gap-1.5">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile
            </a>
        </div>

        {{-- Messages thread --}}
        <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-900/80">
            <div id="chat-thread-scroll"
                 class="max-h-[min(30rem,55vh)] min-h-[14rem] flex-1 overflow-y-auto px-4 py-5 sm:px-5"
                 style="scroll-behavior: smooth;">
                <div class="flex flex-col gap-4">
                    @forelse ($messages as $message)
                        @php $mine = $message->sender_id === auth()->id(); @endphp
                        <div class="flex w-full {{ $mine ? 'justify-end' : 'justify-start' }} items-end gap-2">
                            @unless($mine)
                            <div class="mb-1 grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-cyan-500/30 to-violet-500/30 text-[0.65rem] font-bold text-zinc-200 border border-white/10">
                                {{ Str::upper(Str::substr($message->sender->name, 0, 1)) }}
                            </div>
                            @endunless
                            <div class="group max-w-[75%] sm:max-w-[70%]">
                                @unless($mine)
                                <p class="mb-1 ml-1 text-[0.65rem] font-semibold text-emerald-400">{{ Str::before($message->sender->name, ' ') }}</p>
                                @endunless
                                <div class="rounded-2xl px-4 py-2.5 text-sm leading-relaxed shadow-md
                                    {{ $mine
                                        ? 'rounded-br-sm bg-gradient-to-br from-emerald-600 to-cyan-700 text-white'
                                        : 'rounded-bl-sm border border-white/10 bg-zinc-800 text-zinc-100'
                                    }}">
                                    <p class="whitespace-pre-wrap break-words [overflow-wrap:anywhere]">{{ $message->body }}</p>
                                    <p class="mt-1 text-[0.6rem] {{ $mine ? 'text-white/60 text-right' : 'text-zinc-500' }}">
                                        {{ $message->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/5">
                                <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-zinc-400">No messages yet</p>
                            <p class="mt-0.5 text-xs text-zinc-600">Say hello to {{ Str::before($other->name, ' ') }} 👋</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Composer --}}
        <form method="post" action="{{ route('messages.store', $other) }}" class="flex gap-3 items-end">
            @csrf
            <div class="min-w-0 flex-1">
                <textarea
                    id="body" name="body" rows="2" required maxlength="5000"
                    placeholder="Message {{ Str::before($other->name, ' ') }}…"
                    class="w-full resize-none rounded-2xl border border-white/10 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 placeholder:text-zinc-600 focus:border-emerald-500/40 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="mt-1 text-xs text-red-400">{{ $errors->first('body') }}</p>
                @enderror
            </div>
            <button type="submit"
                class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-600 text-white shadow-lg shadow-emerald-900/30 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
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
