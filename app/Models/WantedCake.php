<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WantedCake extends Model
{

    protected $table = 'wanted_cake';
    protected $fillable = ['user_id',
        'description', 'name', 'phone_number', 'address', 'date', 'payment_type',
        'status'];
}