<?php

namespace Fase\Chat;

use Exception;
use Fase\Chat\Database\Factories\ChatroomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

class Chatroom extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ChatroomFactory::new();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_admin');
    }

    public function join(): void
    {
        /**@var User $user*/
        $user = auth()->user();

        throw_if(!$user, new Exception("Unauthenticated."));

        if ($user->chatrooms()->pluck("chatrooms.id")->doesntContain($this->id)) {
            $user->chatrooms()->attach($this->id);
        }
    }

    public function leave(): void
    {
        /**@var User $user*/
        $user = auth()->user();

        throw_if(!$user, new Exception("Unauthenticated."));

        if ($user->chatrooms()->pluck("chatrooms.id")->contains($this->id)) {
            $user->chatrooms()->detach($this->id);
        }
    }

    public function post(Message $message): void
    {
        /**@var User $user*/
        $user = auth()->user();

        throw_if(!$user, new Exception("Unauthenticated"));

        throw_if($user->chatrooms()->pluck("chatrooms.id")->doesntContain($this->id), new Exception("Unauthorized."));

        $createdMessage = $this->messages()->create($message->toArray());

        SendMessage::dispatch($createdMessage);
    }
}
