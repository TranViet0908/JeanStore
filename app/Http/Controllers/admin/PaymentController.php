<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $req)
{
    $q = Payment::with('order')
        ->when($req->status, fn($x)=>$x->where('status',$req->status))
        ->latest('id')
        ->paginate(15)
        ->appends($req->query());

    return view('admin.payments.index', ['rows'=>$q]);
}


    public function create()
    {
        return view('admin.payments.create', [
            'orders' => Order::latest('id')->limit(100)->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'order_id' => ['required','integer','exists:orders,id'],
            'amount'   => ['required','numeric','min:0'],
            'method'   => ['required','in:cash,credit_card,bank_transfer,e_wallet'],
            'provider' => ['nullable','in:momo,zalopay,vnpay,stripe'],
            'status'   => ['required','in:pending,completed,failed'],
            'provider_txn_id' => ['nullable','string','max:64'],
            'paid_at'  => ['nullable','date'],
        ]);
        $data['payment_date'] = now();
        Payment::create($data);
        return redirect()->route('admin.payments.index')->with('ok','Created');
    }

    public function show(Payment $payment)
    {
        $payment->load('order');
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.edit', [
            'payment'=>$payment,
            'orders'=>Order::latest('id')->limit(100)->get(),
        ]);
    }

    public function update(Request $r, Payment $payment)
    {
        $data = $r->validate([
            'order_id' => ['required','integer','exists:orders,id'],
            'amount'   => ['required','numeric','min:0'],
            'method'   => ['required','in:cash,credit_card,bank_transfer,e_wallet'],
            'provider' => ['nullable','in:momo,zalopay,vnpay,stripe'],
            'status'   => ['required','in:pending,completed,failed'],
            'provider_txn_id' => ['nullable','string','max:64'],
            'paid_at'  => ['nullable','date'],
        ]);
        $payment->update($data);
        return redirect()->route('admin.payments.show',$payment)->with('ok','Updated');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('ok','Deleted');
    }
}
