<?php

namespace Fase\Chat;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait CanChat
{
    public function chatrooms(): BelongsToMany
    {
        return $this->belongsToMany(Chatroom::class)->withPivot('is_admin');
    }

    public function messages(): HasManyThrough
    {
        return $this->hasManyThrough(Message::class, Chatroom::class);
    }
}
