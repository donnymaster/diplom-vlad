<?php

namespace App\Http\Controllers;

use App\DesignPerformer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $designers = DesignPerformer::limit(6)->get();

        return view('index', compact('designers'));
    }
}
