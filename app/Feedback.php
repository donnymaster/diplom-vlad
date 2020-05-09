<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
