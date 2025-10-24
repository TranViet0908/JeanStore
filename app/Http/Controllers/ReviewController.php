<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $req, Product $product)
    {
        $data = $req->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $req->user()->id],
            ['rating' => $data['rating'], 'content' => $data['content'] ?? null, 'is_approved' => true]
        );

        return back()->with('ok', 'Đã ghi nhận đánh giá.');
    }
}
