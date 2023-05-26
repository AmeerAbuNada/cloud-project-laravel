<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }

    public function getParsedData()
    {
        $data = $this->validated();
        $data['role'] = 'manager';
        return $data;
    }
}
