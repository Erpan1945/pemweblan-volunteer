<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = ['volunteer_id','activity_id','status'];

    public function volunteer() { 
        return $this->belongsTo(Volunteer::class); 
    }

    public function activity() { 
        return $this->belongsTo(Activity::class); 
    }
}
