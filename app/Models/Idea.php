<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);

    }

    public function votes(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'votes');
    }

    public function toggleVote(User $user)
    {
        $conditions = [
            'user_id' => $user->id,
            'idea_id' => $this->id,
        ];

        if ($this->isVotedbyUser($user)) {
            $vote = vote::where($conditions)->first();
            return $vote->delete();
        }

        Vote::create($conditions);
    }

    public function isVotedbyUser(User $user)
    {
        if (!$user) {
            return false;
        }

        $conditions = [
            'user_id' => $user->id,
            'idea_id' => $this->id,
        ];
        return Vote::where($conditions)->exists();
    }
}
