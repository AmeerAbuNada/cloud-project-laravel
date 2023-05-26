<?php

namespace App\Http\Requests\Auth\Settings;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
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
        return [
            'name' => 'required|string|min:3|max:28',
            'address' => 'required|string|min:3|max:150',
            'phone' => 'required|string|unique:users,phone_number,' . auth()->user()->id,
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
