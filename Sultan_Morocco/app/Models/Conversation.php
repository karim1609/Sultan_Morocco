<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'last_message_at',
        'last_message_preview',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_user');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public static function findOrCreateDirectBetween(User $a, User $b): self
    {
        if ($a->is($b)) {
            abort(403, 'You cannot start a conversation with yourself.');
        }

        $existing = self::query()
            ->whereHas('users', fn ($q) => $q->where('users.id', $a->id))
            ->whereHas('users', fn ($q) => $q->where('users.id', $b->id))
            ->withCount('users')
            ->get()
            ->first(fn ($c) => $c->users_count === 2);

        if ($existing) {
            return $existing;
        }

        $conversation = self::create();
        $conversation->users()->attach([$a->id, $b->id]);

        return $conversation;
    }

    public function otherParticipant(User $viewer): ?User
    {
        return $this->users->firstWhere('id', '!=', $viewer->id);
    }
}
