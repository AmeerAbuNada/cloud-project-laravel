<?php

namespace App\Http\Requests\UserSection\Project;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'for' => 'required|string|in:project,task',
            'file_name' => 'required|string',
            'file' => 'required|file',
        ];
    }
}
