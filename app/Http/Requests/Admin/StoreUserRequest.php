<?php

// app/Http/Requests/Admin/StoreUserRequest.php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'fullname' => ['required','string','max:120'],
            'email'    => ['required','email','max:191','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'role'     => ['required', Rule::in(['admin','staff','user'])],
            'phone'    => ['nullable','string','max:32','unique:users,phone'],
            'address'  => ['nullable','string','max:255'],
        ];
    }
}
