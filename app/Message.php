<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const UPDATED_AT = null;
    protected $fillable = ['user_id_receiver', 'user_id_sender','title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
