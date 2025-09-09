<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /** @use HasFactory<\Database\Factories\FollowFactory> */
    use HasFactory;

    protected $fillable = ['organizer_id','volunteer_id','notification'];

    public function organizer() { 
        return $this->belongsTo(Organizer::class); 
    }

    public function volunteer() { return $this->belongsTo(Volunteer::class); }
}
