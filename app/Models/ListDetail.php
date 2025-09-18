<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ListDetailFactory> */
    use HasFactory;

    protected $fillable = ['list_id','activity_id'];

    public function activityList() {
        return $this->belongsTo(ActivityList::class, 'list_id');
    }

    public function activity() { 
        return $this->belongsTo(Activity::class, 'activity_id'); 
    }
}
