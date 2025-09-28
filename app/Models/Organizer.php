<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
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
}


