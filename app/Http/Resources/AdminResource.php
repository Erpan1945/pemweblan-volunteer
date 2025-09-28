<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->admin_id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => 'admin', // Tambahkan role agar jelas di frontend
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}