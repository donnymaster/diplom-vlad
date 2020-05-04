<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignType extends Model
{
    protected $table = 'design_types';

    protected $fillable = [
        'design_name'
    ];

}
