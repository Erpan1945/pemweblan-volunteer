<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Organizer extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * Nama primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'organizer_id'; // <-- INI PERBAIKAN UTAMA

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone_number', 'password', 'date_of_establishment', 
        'description', 'logo', 'website', 'instagram', 'tiktok', 'province', 'city'
    ];

    /**
     * Mendefinisikan relasi ke Activity.
     */
    public function activities() { 
        return $this->hasMany(Activity::class, 'organizer_id', 'organizer_id'); 
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'following',
            'organizer_id', 'volunteer_id')
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


