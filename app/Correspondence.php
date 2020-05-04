<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $table = 'correspondence';

    protected $fillable = [
        'user_id',
        'message',
        'broadcast_identifier'
    ];

}
