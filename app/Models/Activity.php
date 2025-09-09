<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'organizer_id','title','description','registration_start_date','registration_end_date','activity_start_date','activity_end_date','location','thumbnail'
    ];

    public function organizer() { 
        return $this->belongsTo(Organizer::class); 
    }

    public function enrollments() { 
        return $this->hasMany(Enrollment::class); 
    }

    public function volunteers() { 
        return $this->belongsToMany(Volunteer::class, 'enrollments'); 
    }

    public function reviews() { 
        return $this->hasMany(Review::class); 
    }
}
