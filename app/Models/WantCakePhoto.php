<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WantCakePhoto extends Model
{

    protected $table = 'want_cake_photo';
    protected $fillable = ['want_cake_id', 'file_id'];

}