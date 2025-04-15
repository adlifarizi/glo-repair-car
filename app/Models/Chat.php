<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'id_chat_sessions',
        'sender',
        'content',
    ];

    protected $table = 'chat';

    public function ChatSessions()
    {
        return $this->belongsTo(Chat_Sessions::class);
    }
}
