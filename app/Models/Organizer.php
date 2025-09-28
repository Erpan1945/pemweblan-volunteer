<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Conntracts\JWTSubject;

class Organizer extends Authecticable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\OrganizerFactory> */
    use HasFactory;

    protected $primaryKey = 'organizer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name','email','phone_number','password','date_of_establishment','description','logo','website','instagram','tiktok','province','city'
    ];

        //JWTSubject methods
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return[];
    }

    public function requests() { 
        return $this->hasMany(ActivityRequest::class); 
    } 

    public function activities() { 
        return $this->hasMany(Activity::class); 
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'following',
            'organizer_id', 'volunteer_id')
            ->withTimestamps()
            ->withPivot(['notification']);
    } 


}
