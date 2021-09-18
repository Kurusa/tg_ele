<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'order';
    protected $fillable = ['user_id',
        'description', 'name', 'phone_number', 'address', 'date', 'payment_type',
    'status'];

}