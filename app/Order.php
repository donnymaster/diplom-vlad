<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'customer_id',
        'design_performer_id',
        'design_type_id',
        'title',
        'description',
        'attachment',
        'broadcast_identifier',
        'cost',
        'notification_order_id'
    ];
}
