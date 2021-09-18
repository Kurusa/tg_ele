<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPhoto extends Model
{

    protected $table = 'order_photo';
    protected $fillable = ['order_id', 'file_id'];

}