<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $rows = Coupon::latest('id')->paginate(15);
        return view('admin.coupons.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'code'            => ['required', 'string', 'max:64', 'unique:coupons,code'],
            'type'            => ['required', 'in:percent,fixed'], // bắt buộc
            'discount'        => ['required', 'integer', 'min:0'],   // map sang value
            'max_uses'        => ['nullable', 'integer', 'min:0'],
            'max_discount'    => ['nullable', 'integer', 'min:0'],
            'min_order_total' => ['nullable', 'integer', 'min:0'],
            'starts_at'       => ['nullable', 'date'],
            'ends_at'         => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active'       => ['nullable', 'boolean'],
        ]);

        $payload = [
            'code'            => $data['code'],
            'type'            => $data['type'],
            'value'           => (int)$data['discount'],
            'max_uses'        => $data['max_uses']        ?? 0,
            'used'            => 0,
            'max_discount'    => $data['max_discount']    ?? 0,
            'min_order_total' => $data['min_order_total'] ?? 0,
            'starts_at'       => $data['starts_at']       ?? null,
            'ends_at'         => $data['ends_at']         ?? null,
            'active'          => array_key_exists('is_active', $data) ? (bool)$data['is_active'] : true,
        ];

        Coupon::create($payload);

        return redirect()->route('admin.coupons.index')->with('ok', 'Created');
    }


    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $r, Coupon $coupon)
    {
        $data = $r->validate([
            'code'      => ['required', 'string', 'max:50'],
            'discount'  => ['required', 'numeric', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at'   => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $coupon->update($data);
        return redirect()->route('admin.coupons.show', $coupon)->with('ok', 'Updated');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('ok', 'Deleted');
    }
}
