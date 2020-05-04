<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCompleted extends Model
{
    protected $table = 'order_completed';

    protected $fillable = [
        'order_id',
        'design_performer',
        'rating',
        'attachment'
    ];

}
