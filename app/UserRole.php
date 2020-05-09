<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    protected $table = 'roles';

    protected $fillable = [
        'role_name'
    ];

    public function user(){
        return $this->hasOne(User::class, 'role_id');
    }
}
