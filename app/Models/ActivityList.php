<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityList extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityListFactory> */
    use HasFactory;

    protected $fillable = ['volunteer_id','name'];

    public function volunteer() { 
        return $this->belongsTo(Volunteer::class); 
    }

    public function details() { 
        return $this->hasMany(ListDetail::class); 
    }

    public function activities() { 
        return $this->belongsToMany(Activity::class, 'list_details', 'list_id', 'activity_id'); 
    }
}
