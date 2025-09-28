<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        $activity = $this->route('activity');
        // --- UBAH 'pending' MENJADI 'menunggu verifikasi admin' ---
        return $activity->status === 'menunggu verifikasi admin';
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|min:3|max:255',
            'description' => 'sometimes|required|string|min:10',
            'registration_start_date' => 'sometimes|required|date',
            'registration_end_date' => 'sometimes|required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'sometimes|required|date',
            'activity_end_date' => 'sometimes|required|date|after_or_equal:activity_start_date',
            'location' => 'sometimes|required|string|min:3|max:255',
            'thumbnail' => 'nullable|url',
        ];
    }
}