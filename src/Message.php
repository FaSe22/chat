<?php

namespace Fase\Chat;

use Fase\Chat\Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    protected static function newFactory()
    {
        return MessageFactory::new();
    }

    public function chatroom(): BelongsTo
    {
        return $this->belongsTo(Chatroom::class);
    }
}
