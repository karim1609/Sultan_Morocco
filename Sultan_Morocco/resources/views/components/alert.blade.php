@if (session('success'))
    <div class="mb-6 rounded-2xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
        <div class="flex items-start justify-between gap-3">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wider text-emerald-200/80">Success</div>
                <div class="mt-1 font-medium">{{ session('success') }}</div>
            </div>
            <div class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-emerald-300 shadow-[0_0_0_6px_rgba(52,211,153,0.12)]"></div>
        </div>
    </div>
@endif