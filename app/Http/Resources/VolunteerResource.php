<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->volunteer_id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'role' => 'volunteer',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}