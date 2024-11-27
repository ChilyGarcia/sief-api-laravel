<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $sender_id = auth()->guard('api')->user()->id;
        $receiver_id = $request->receiver_id;
        $message = $request->message;

        if (empty($receiver_id)) {
            return response()->json(['error' => 'Receiver id is required'], 400);
        }

        if ($sender_id == $receiver_id) {
            return response()->json(['error' => 'You cannot send a message to yourself'], 400);
        }

        event(new MessageSent($sender_id, $receiver_id, $message));

        $newMessage = Message::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
        ]);

        return response()->json(['status' => 'Message sent', 'message' => $newMessage], 200);
    }

    public function getMessages(Request $request)
    {
        $user = auth()->guard('api')->user();
        $receiverId = $request->input('receiver_id');

        if ($receiverId == $user->id) {
            return response()->json(['error' => 'You cannot get messages from yourself'], 400);
        }

        if (empty($receiverId)) {
            return response()->json(['error' => 'Receiver id is required'], 400);
        }

        $messages = Message::where(function ($query) use ($user, $receiverId) {
            $query->where(function ($q) use ($user, $receiverId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $receiverId);
            })->orWhere(function ($q) use ($user, $receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', $user->id);
            });
        })->get();

        return response()->json($messages);
    }
}
