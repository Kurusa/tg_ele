<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotUser extends Model
{

    protected $table = 'bot_user';
    protected $fillable = ['chat_id', 'first_name', 'user_name', 'status'];

}