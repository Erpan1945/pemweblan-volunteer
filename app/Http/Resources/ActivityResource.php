<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Menggunakan primary key yang benar
            'activity_id' => $this->activity_id, 
            // Memuat relasi 'organizer' dan mengambil 'name' nya
            'organizer_name' => $this->whenLoaded('organizer', $this->organizer->name),
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->registration_end_date,
            'activity_start_date' => $this->activity_start_date,
            'activity_end_date' => $this->activity_end_date,
            'location' => $this->location,
            'thumbnail' => $this->thumbnail,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}