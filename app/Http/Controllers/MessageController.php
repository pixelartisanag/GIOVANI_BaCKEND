<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Group $group)
    {
        $messages = $group->messages()->with('user')->get();

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        $message = new Message();
        $message->body = $request->message;
        $message->group_id = $request->group_id;
        $message->user_id = Auth::user()->id;
        $message->user()->associate(Auth::user());
        $message->save();

        $message->load('user');
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }

    public function send(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'body' => 'required|string',
        ]);

        $message = new Message([
            'user_id' => $request->user_id,
            'body' => $request->message,
        ]);

        $group->messages()->save($message);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }

    public function oneToOneChat(User $sender, User $receiver)
    {
        // Assuming you have a 'direct_message' column in the messages table to differentiate group and direct messages
        $messages = Message::whereIn('user_id', [$sender->id, $receiver->id])
            ->whereIn('receiver_id', [$sender->id, $receiver->id])
            ->where('direct_message', true)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
