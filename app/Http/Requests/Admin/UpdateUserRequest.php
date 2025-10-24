<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // route model binding: 'user' từ UserController@update(User $user)
        $id = $this->route('user')?->id;

        return [
            'full_name' => ['required','string','max:255'],
            'email'     => [
                'required','email','max:255',
                Rule::unique('users','email')->ignore($id)
            ],
            'phone'     => [
                'nullable','string','max:20',
                Rule::unique('users','phone')->ignore($id)
            ],
            'role'      => ['required','in:admin,staff,user'],
            'address'   => ['nullable','string','max:255'],
            'password'  => ['nullable','string','min:8','confirmed'],
        ];
    }
}
