<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    /** @use HasFactory<\Database\Factories\VolunteerFactory> */
    use HasFactory;

    protected $primaryKey = 'volunteer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name','email','password','gender','birth_date','province','city'
    ];

    // relasi
    public function enrollments() { 
        return $this->hasMany(Enrollment::class); 
    }

    public function activities() { 
        return $this->belongsToMany(Activity::class, 'enrollments'); 
    }

    public function reviews() { 
        return $this->hasMany(Review::class); 
    }

    public function activityLists() { 
        return $this->hasMany(ActivityList::class); 
    }

    public function follows() { 
        return $this->hasMany(Follow::class); 
    }
}
