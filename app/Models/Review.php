<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = ['volunteer_id','activity_id','rating','comment'];

    public function volunteer() { 
        return $this->belongsTo(Volunteer::class); 
    }

    public function activity() { 
        return $this->belongsTo(Activity::class); 
    }
}
