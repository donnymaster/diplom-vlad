<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignPerformer extends Model
{
    protected $table = 'design_performer';

    protected $fillable = [
        'name',
        'surname',
        'description',
        'design_type_id',
        'avatar'
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'design_performer_id');
    }
}
