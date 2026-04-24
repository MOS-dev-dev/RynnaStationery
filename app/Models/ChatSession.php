<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id', 'mode'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
