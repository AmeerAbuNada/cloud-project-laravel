<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:40',
            'description' => 'required|string|min:8|max:4096',
            'user' => 'required|integer|exists:users,id',
            'status' => 'required|string|in:In Progress,Completed,Canceled',
        ];
    }
}
