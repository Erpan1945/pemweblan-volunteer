<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules()
    {
        return [
           'organizer_id' => 'required|integer|exists:organizers,organizer_id', 
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after_or_equal:activity_start_date',
            'location' => 'required|string|min:3|max:255',
            'thumbnail' => 'nullable|url',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }
}
