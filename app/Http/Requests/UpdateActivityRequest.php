<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'organizer_id' => 'sometimes|required|integer|exists:organizers,id',
            'title' => 'sometimes|required|string|min:3|max:255',
            'description' => 'sometimes|required|string|min:10',
            'registration_start_date' => 'sometimes|required|date',
            'registration_end_date' => 'sometimes|required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'sometimes|required|date',
            'activity_end_date' => 'sometimes|required|date|after_or_equal:activity_start_date',
            'location' => 'sometimes|required|string|min:3|max:255',
            'thumbnail' => 'sometimes|nullable|url',
            'status' => 'sometimes|in:pending,approved,rejected',
        ];
    }

}
