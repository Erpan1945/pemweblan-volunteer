<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';

    protected $fillable = [
        'organizer_id', 'title', 'description', 'registration_start_date',
        'registration_end_date', 'activity_start_date', 'activity_end_date',
        'location', 'thumbnail', 'status', 'rejection_reason',
    ];

    public function organizer()
    {
        // Foreign Key di tabel activities, Owner Key di tabel organizers
        return $this->belongsTo(Organizer::class, 'organizer_id', 'organizer_id');
    }
}