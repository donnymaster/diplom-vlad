<?php

namespace App\Http\Controllers;

use App\Correspondence;
use App\Events\MessageSent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function fetchMessages(Request $request)
    {
        return Correspondence::where('broadcast_identifier', '=', $request->input('id'))->with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = Correspondence::create([
            'user_id' => $request->input('user_id'),
            'broadcast_identifier' => $request->input('broadcast_identifier'),
            'message' => $request->input('message')
        ]);

        // return $message;

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
