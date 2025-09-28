<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->organizer_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'logo_url' => $this->logo ? asset('storage/' . $this->logo) : null,
            'role' => 'organizer',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}