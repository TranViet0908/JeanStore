<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportFaq;
use Illuminate\Http\Request;

class SupportFaqController extends Controller
{
    public function index(Request $r)
    {
        $rows = SupportFaq::query()
            ->when($r->q, fn($q) => $q->where('question', 'like', '%' . $r->q . '%'))
            ->orderByDesc('id')                // bỏ orderBy('order')
            ->paginate(20)->appends($r->query());

        return view('admin.faqs.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer'  => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $row = SupportFaq::create($data);     // không gửi field 'order'
        return redirect()->route('admin.faqs.show', $row)->with('success', 'Đã tạo FAQ');
    }

    public function show(SupportFaq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }

    public function edit(SupportFaq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $r, SupportFaq $faq)
    {
        $data = $r->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer'  => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $faq->update($data);                  // không gửi field 'order'
        return redirect()->route('admin.faqs.show', $faq)->with('success', 'Đã cập nhật FAQ');
    }

    public function destroy(SupportFaq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Đã xóa');
    }
}
