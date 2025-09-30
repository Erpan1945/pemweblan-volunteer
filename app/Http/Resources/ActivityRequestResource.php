<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'request_id' => $this->request_id,
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'activity_starts' => $this->activity_start_date,
            'activity_ends' => $this->activity_end_date,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            // Sertakan data organizer jika relasi 'organizer' sudah di-load
            'organizer' => new OrganizerResource($this->whenLoaded('organizer')),
        ];
    }
}