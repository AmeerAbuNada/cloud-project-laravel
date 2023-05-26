<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd(123);
        return [
            'name' => 'required|string|min:3|max:28',
            'email' => 'required|email|unique:users,email,' . $this->user,
            'address' => 'required|string|min:3|max:80',
            'phone' => 'required|string|unique:users,phone_number,' . $this->user,
            'role' => 'required|in:user,admin',
        ];
    }
}
