<?php

namespace App\Http\Requests\UserSection\Project;

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
        return $this->project->user_id == auth()->user()->id;
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
            'status' => 'required|string|in:In Progress,Completed,Canceled',
        ];
    }
}
