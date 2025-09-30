<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Volunteer extends Authenticatable implements JWTSubject
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
        return $this->hasMany(ActivityList::class, 'volunteer_id', 'volunteer_id'); 
    }

    public function organizers(){
        return $this->belongsToMany(Organizer::class, 'following',
            'volunteer_id', 'organizer_id')
            ->withTimestamps()
            ->withPivot(['notification']);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
