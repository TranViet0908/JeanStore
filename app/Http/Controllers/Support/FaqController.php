<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\SupportFaq;

class FaqController extends Controller
{
    public function index() {
        $faqs = SupportFaq::where('is_active',1)->orderBy('sort_order')->orderByDesc('id')->get();
        return view('support.faq.index', compact('faqs'));
    }
}
