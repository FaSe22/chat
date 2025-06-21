<?php

namespace Fase\Chat;

use Fase\Chat\Message;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where('id', auth()->id())->select([
            'id', 'name', 'email',
        ])->first();

        return view('home', [
            'user' => $user,
        ]);
    }

    public function messages(): JsonResponse
    {
        $messages = Message::with('user')->get()->append('time');

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse
    {
        /**@var Chatroom $chatroom*/
        $chatroom = Chatroom::findOrFail($request->chatroom_id);

        $message = new Message([
            'user_id' => auth()->id(),
            'content' => $request->get('content'),
        ]);

        $chatroom->post($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
