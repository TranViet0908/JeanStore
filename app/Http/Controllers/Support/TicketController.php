<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index() {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderByDesc('updated_at')->paginate(10);
        return view('support.tickets.index', compact('tickets'));
    }

    public function create() {
        $me = Auth::user();
        return view('support.tickets.create', ['me' => $me]);
    }

    public function store(Request $r) {
        $data = $r->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $ticket = SupportTicket::create([
            'code' => SupportTicket::genCode(),
            'user_id' => Auth::id(),
            'requester_email' => Auth::user()->email ?? null,
            'requester_name' => Auth::user()->name ?? null,
            'subject' => $data['subject'],
            'content' => $data['content'],
            'status' => 'open',
            'priority' => 'normal',
            'conversation' => [[
                'at' => now()->format('Y-m-d H:i:s'),
                'from' => 'user',
                'body' => $data['content']
            ]],
            'last_message_at' => now(),
        ]);

        return redirect()->route('support.tickets.show', $ticket->id)
            ->with('ok', 'Đã tạo ticket');
    }

    public function show($id) {
        $ticket = SupportTicket::where('id',$id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        return view('support.tickets.show', compact('ticket'));
    }

    public function reply($id, Request $r) {
        $ticket = SupportTicket::where('id',$id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $r->validate(['body' => 'required|string|max:3000']);
        $conv = $ticket->conversation ?? [];
        $conv[] = [
            'at' => now()->format('Y-m-d H:i:s'),
            'from' => 'user',
            'body' => $r->input('body')
        ];
        $ticket->conversation = $conv;
        $ticket->last_message_at = now();
        $ticket->status = $ticket->status === 'resolved' ? 'open' : $ticket->status;
        $ticket->save();

        return back();
    }
}
