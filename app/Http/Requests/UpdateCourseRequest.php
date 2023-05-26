<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'is_paid' => 'required|string|in:paid,free',
            'cost' => 'required_if:is_paid,paid',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
        ];
    }

    public function getParsedData()
    {
        $data = $this->validated();
        if ($data['is_paid'] == 'free') {
            $data['cost'] = 0;
        }
        return $data;
    }
}
