<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:150',
            'time' => 'required|date',
        ];
    }

    public function getParsedDate()
    {
        $data = $this->validated();
        $data['trainee_id'] = $this->user()->id;
        $data['advisor_id'] = $this->course->user_id;
        return $data;
    }
}
