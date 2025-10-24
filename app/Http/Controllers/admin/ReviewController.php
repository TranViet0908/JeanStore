<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $r)
    {
        $rows = Review::with(['product','user'])
            ->when($r->q, fn($q)=>$q->where('content','like','%'.$r->q.'%'))
            ->when($r->product_id, fn($q)=>$q->where('product_id',$r->product_id))
            ->when($r->user_id, fn($q)=>$q->where('user_id',$r->user_id))
            ->when($r->filled('is_approved'), fn($q)=>$q->where('is_approved',(bool)$r->is_approved))
            ->when($r->rating, fn($q)=>$q->where('rating',$r->rating))
            ->latest('id')
            ->paginate(15)
            ->appends($r->query());

        return view('admin.reviews.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.reviews.create', [
            'products' => Product::latest('id')->limit(100)->get(),
            'users'    => User::latest('id')->limit(100)->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'product_id'  => ['required','exists:products,id'],
            'user_id'     => ['required','exists:users,id'],
            'rating'      => ['required','integer','min:1','max:5'],
            'content'     => ['nullable','string'],
            'is_approved' => ['nullable','boolean'],
        ]);
        $data['is_approved'] = (bool)($data['is_approved'] ?? false);

        $row = Review::create($data);
        return redirect()->route('admin.reviews.show',$row)->with('success','Đã tạo đánh giá');
    }

    public function show(Review $review)
    {
        $review->load(['product','user']);
        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', [
            'review'   => $review,
            'products' => Product::latest('id')->limit(100)->get(),
            'users'    => User::latest('id')->limit(100)->get(),
        ]);
    }

    public function update(Request $r, Review $review)
    {
        $data = $r->validate([
            'product_id'  => ['required','exists:products,id'],
            'user_id'     => ['required','exists:users,id'],
            'rating'      => ['required','integer','min:1','max:5'],
            'content'     => ['nullable','string'],
            'is_approved' => ['nullable','boolean'],
        ]);
        $data['is_approved'] = (bool)($data['is_approved'] ?? false);

        $review->update($data);
        return redirect()->route('admin.reviews.show',$review)->with('success','Đã cập nhật');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success','Đã xóa đánh giá');
    }
}
