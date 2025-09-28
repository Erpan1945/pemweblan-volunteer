<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Conntracts\JWTSubject;

class Volunteer extends Authecticable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\VolunteerFactory> */
    use HasFactory;

    protected $primaryKey = 'volunteer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name','email','password','gender','birth_date','province','city'
    ];

    //JWTSubject methods
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return[];
    }

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

    public function organizers(){
        return $this->belongsToMany(Organizer::class, 'following',
            'volunteer_id', 'organizer_id')
            ->withTimestamps()
            ->withPivot(['notification']);
    }

}
