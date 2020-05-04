<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'notification_order';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment'
    ];

}
