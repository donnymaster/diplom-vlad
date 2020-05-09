<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Order;

class UserOrderController extends Controller
{
    public function __construct()
    {
        // // policy on the delete order
        // $this->authorizeResource(Order::class, 'delete');   
    }
    // использовать datatables
}
