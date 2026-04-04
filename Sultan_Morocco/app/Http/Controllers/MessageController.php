<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function openByUserId(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $target = User::findOrFail($validated['user_id']);

        if ($target->is($request->user())) {
            return back()->withErrors([
                'user_id' => 'You cannot start a chat with yourself.',
            ]);
        }

        return redirect()->route('messages.show', $target);
    }

    public function index(Request $request): View
    {
        $user = $request->user();

        $conversations = $user
            ->conversations()
            ->with(['users'])
            ->withCount([
                'messages as unread_count' => fn ($q) => $q
                    ->whereNull('read_at')
                    ->where('sender_id', '!=', $user->id),
            ])
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        $latestByConversation = collect();
        if ($conversations->isNotEmpty()) {
            $ids = $conversations->pluck('id');
            $latestByConversation = Message::query()
                ->whereIn('id', function ($query) use ($ids) {
                    $query->selectRaw('max(id)')
                        ->from('messages')
                        ->whereIn('conversation_id', $ids)
                        ->groupBy('conversation_id');
                })
                ->get()
                ->keyBy('conversation_id');
        }

        return view('messages.index', [
            'conversations' => $conversations,
            'latestByConversation' => $latestByConversation,
        ]);
    }

    public function show(Request $request, User $user): View
    {
        $viewer = $request->user();

        if ($user->is($viewer)) {
            abort(403, 'You cannot message yourself.');
        }

        $conversation = Conversation::findOrCreateDirectBetween($viewer, $user);

        Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $viewer->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation
            ->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        return view('messages.show', [
            'conversation' => $conversation,
            'other' => $user,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $viewer = $request->user();

        if ($user->is($viewer)) {
            abort(403, 'You cannot message yourself.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $conversation = Conversation::findOrCreateDirectBetween($viewer, $user);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $viewer->id,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'last_message_preview' => Str::limit($validated['body'], 120),
        ]);

        return redirect()
            ->route('messages.show', $user)
            ->with('success', 'Message sent.');
    }
}
