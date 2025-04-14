<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat_Sessions extends Model
{
    protected $fillable = [
        'expired_at',
    ];

    protected $table = 'chat_sessions';
    
    public function Chats(){
        return $this->hasMany(Chat::class);
    }
    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set expired_at ke 24 jam setelah created_at
            $model->expired_at = Carbon::now()->addHours(24);
        });
    }
}
