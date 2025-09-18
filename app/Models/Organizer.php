<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizerFactory> */
    use HasFactory;

    protected $primaryKey = 'organizer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name','email','phone_number','password','date_of_establishment','description','logo','website','instagram','tiktok','province','city'
    ];

    public function requests() { 
        return $this->hasMany(ActivityRequest::class); 
    } 

    public function activities() { 
        return $this->hasMany(Activity::class); 
    }

    public function followers() { 
        return $this->hasMany(Follow::class); 
    }
}
