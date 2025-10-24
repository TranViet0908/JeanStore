<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportLiveChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LiveChatController extends Controller
{
    public function index(Request $r) {
        // Lấy hoặc tạo session chat
        $chatId = $r->session()->get('live_chat_id');
        $chat = null;

        if ($chatId) {
            $chat = SupportLiveChat::find($chatId);
        }

        if (!$chat) {
            $payload = [
                'status' => 'active',
                'messages' => [],
                'started_at' => now(),
                'last_message_at' => null,
            ];
            if (Auth::check()) {
                $payload['user_id'] = Auth::id();
            } else {
                $payload['guest_token'] = 'guest_'.Str::random(12);
            }
            $chat = SupportLiveChat::create($payload);
            $r->session()->put('live_chat_id', $chat->id);
        }

        return view('support.live_chat.index', ['chat' => $chat]);
    }

    public function send(Request $r) {
        $r->validate(['body' => 'required|string|max:2000']);
        $chatId = $r->session()->get('live_chat_id');
        abort_unless($chatId, 404);

        $chat = SupportLiveChat::findOrFail($chatId);
        $messages = $chat->messages ?? [];
        $messages[] = [
            'at' => now()->format('Y-m-d H:i:s'),
            'from' => 'user',
            'body' => $r->input('body')
        ];

        $chat->messages = $messages;
        $chat->last_message_at = now();
        $chat->save();

        return response()->json(['ok' => true]);
    }

    public function poll(Request $r) {
        $chatId = $r->session()->get('live_chat_id');
        abort_unless($chatId, 404);

        $chat = SupportLiveChat::findOrFail($chatId);
        return response()->json([
            'status' => $chat->status,
            'messages' => $chat->messages ?? [],
        ]);
    }
}
