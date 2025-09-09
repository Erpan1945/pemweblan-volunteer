<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityRequest extends Model
{
    use HasFactory;

    protected $table = 'requests'; // jika tabel tetap bernama 'requests'

    protected $fillable = [
        'organizer_id',
        'status',
        'title',
        'description',
        'registration_start_date',
        'registration_end_date',
        'activity_start_date',
        'activity_end_date',
        'location',
        'thumbnail',
    ];

    // Relasi ke Organizer
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }
}
