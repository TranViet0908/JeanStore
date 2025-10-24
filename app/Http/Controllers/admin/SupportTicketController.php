<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $r)
    {
        $rows = SupportTicket::query()
            ->when($r->q, fn($q)=>$q->where(function($x) use($r){
                $x->where('code','like','%'.$r->q.'%')
                  ->orWhere('subject','like','%'.$r->q.'%')
                  ->orWhere('requester_email','like','%'.$r->q.'%')
                  ->orWhere('requester_name','like','%'.$r->q.'%');
            }))
            ->when($r->status, fn($q)=>$q->where('status',$r->status))
            ->when($r->priority, fn($q)=>$q->where('priority',$r->priority))
            ->when($r->user_id, fn($q)=>$q->where('user_id',$r->user_id))
            ->when($r->order_id, fn($q)=>$q->where('order_id',$r->order_id))
            ->latest('id')->paginate(15)->appends($r->query());

        return view('admin.tickets.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.tickets.create', [
            'users'  => User::latest('id')->limit(100)->get(),
            'orders' => Order::latest('id')->limit(100)->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'user_id'         => ['nullable','exists:users,id'],
            'requester_email' => ['nullable','email','max:190'],
            'requester_name'  => ['nullable','string','max:190'],
            'subject'         => ['required','string','max:255'],
            'content'         => ['required','string'],
            'status'          => ['required','in:open,pending,closed'],
            'priority'        => ['nullable','in:low,normal,high'],
            'assigned_to'     => ['nullable','exists:users,id'],
            'order_id'        => ['nullable','exists:orders,id'],
            'conversation'    => ['nullable','array'],
            'last_message_at' => ['nullable','date'],
            'closed_at'       => ['nullable','date'],
        ]);
        $row = SupportTicket::create($data);
        return redirect()->route('admin.tickets.show',$row)->with('success','Đã tạo ticket');
    }

    public function show(SupportTicket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(SupportTicket $ticket)
    {
        return view('admin.tickets.edit', [
            'ticket'=>$ticket,
            'users'=>User::latest('id')->limit(100)->get(),
            'orders'=>Order::latest('id')->limit(100)->get(),
        ]);
    }

    public function update(Request $r, SupportTicket $ticket)
    {
        $data = $r->validate([
            'user_id'         => ['nullable','exists:users,id'],
            'requester_email' => ['nullable','email','max:190'],
            'requester_name'  => ['nullable','string','max:190'],
            'subject'         => ['required','string','max:255'],
            'content'         => ['required','string'],
            'status'          => ['required','in:open,pending,closed'],
            'priority'        => ['nullable','in:low,normal,high'],
            'assigned_to'     => ['nullable','exists:users,id'],
            'order_id'        => ['nullable','exists:orders,id'],
            'conversation'    => ['nullable','array'],
            'last_message_at' => ['nullable','date'],
            'closed_at'       => ['nullable','date'],
        ]);
        $ticket->update($data);
        return redirect()->route('admin.tickets.show',$ticket)->with('success','Đã cập nhật');
    }

    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success','Đã xóa');
    }
}
