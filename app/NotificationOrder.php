<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationOrder extends Model
{
    protected $table = 'notification_order';

    protected $fillable = [
        'message'
    ];

}
