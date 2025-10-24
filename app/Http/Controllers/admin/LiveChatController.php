<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportLiveChat;
use App\Models\User;
use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    public function index(Request $r)
    {
        $rows = SupportLiveChat::query()
            ->when($r->q, fn($q)=>$q->where(function($x) use($r){
                $x->where('guest_name','like','%'.$r->q.'%')
                  ->orWhere('guest_email','like','%'.$r->q.'%');
            }))
            ->when($r->status, fn($q)=>$q->where('status',$r->status))
            ->when($r->user_id, fn($q)=>$q->where('user_id',$r->user_id))
            ->latest('last_message_at')->latest('id')
            ->paginate(15)->appends($r->query());

        return view('admin.livechats.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.livechats.create', [
            'users'=>User::latest('id')->limit(100)->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'user_id'     => ['nullable','exists:users,id'],
            'guest_name'  => ['nullable','string','max:190'],
            'guest_email' => ['nullable','string','max:190'],
            'status'      => ['nullable','in:active,ended'],
            'messages'    => ['nullable','array'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date'],
        ]);

        $row = SupportLiveChat::create($data);
        return redirect()->route('admin.livechats.show',$row)->with('success','Đã tạo phiên chat');
    }

    public function show(SupportLiveChat $livechat)
    {
        return view('admin.livechats.show', compact('livechat'));
    }

    public function edit(SupportLiveChat $livechat)
    {
        return view('admin.livechats.edit', [
            'livechat'=>$livechat,
            'users'=>User::latest('id')->limit(100)->get(),
        ]);
    }

    public function update(Request $r, SupportLiveChat $livechat)
    {
        $data = $r->validate([
            'user_id'     => ['nullable','exists:users,id'],
            'guest_name'  => ['nullable','string','max:190'],
            'guest_email' => ['nullable','string','max:190'],
            'status'      => ['required','in:active,ended'],
            'messages'    => ['nullable','array'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date'],
            'last_message_at' => ['nullable','date'],
        ]);

        $livechat->update($data);
        return redirect()->route('admin.livechats.show',$livechat)->with('success','Đã cập nhật');
    }

    public function destroy(SupportLiveChat $livechat)
    {
        $livechat->delete();
        return redirect()->route('admin.livechats.index')->with('success','Đã xóa');
    }

    /** Thêm 1 message vào JSON messages */
    public function addMessage(Request $r, SupportLiveChat $livechat)
    {
        $data = $r->validate([
            'body' => ['required','string'],
            'by'   => ['nullable','in:user,agent,system'],
        ]);
        $livechat->pushMessage($data['body'], $data['by'] ?? null);
        return back()->with('success','Đã thêm tin nhắn');
    }
}
