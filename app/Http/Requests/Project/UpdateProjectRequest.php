<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:80',
            'description' => 'required|string|min:10|max:4096',
            'deadline' => 'required|date',
            'user' => 'required|integer|exists:users,id',
            'client' => 'required|integer|exists:clients,id',
            'status' => 'required|string|in:In Progress,Completed,Canceled',
        ];
    }
}
