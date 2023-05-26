<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:190',
            'vat' => 'required|integer|unique:clients,vat,' . $this->client,
            'address' => 'required|string|min:3|max:190',
            'city' => 'required|string|min:3|max:60',
            'zip' => 'required|string|min:5|max:9',
            'contact_name' => 'required|string|min:3|max:190',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|min:7|max:25',
        ];
    }
}
