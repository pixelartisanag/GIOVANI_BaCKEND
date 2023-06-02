<?php

namespace App\Http\Controllers;

use App\Events\Signal;
use App\Events\UserDisconnected;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class BroadcastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function authenticate(Request $request)
    {
        Log::info('BroadcastController@authenticate', [
            'request' => $request->all(),
            'user' => $request->user()
        ]);

        return Broadcast::auth($request);
    }

    public function setTyping(Request $request)
    {
        $user = Auth::user();
        $groupId = $request->input('group_id');
        $isTyping = $request->input('is_typing');

        broadcast(new UserTyping($user, $groupId, $isTyping));

        return response()->json(['status' => 'success']);
    }

    public function signal(Request $request)
    {
        $roomId = $request->input('roomId');
        $signalData = $request->input('signalData');

        broadcast(new Signal($roomId, $signalData));

        return response()->json(['status' => 'success']);
    }

    public function disconnect(Request $request)
    {
        $roomId = $request->input('roomId');
        $userId = $request->input('userId');

        broadcast(new UserDisconnected($roomId, $userId));

        return response()->json(['status' => 'success']);
    }
}
