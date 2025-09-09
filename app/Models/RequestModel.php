<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    /** @use HasFactory<\Database\Factories\RequestFactory> */
    use HasFactory;

    protected $table = 'requests';
    protected $fillable = [
        'organizer_id','status','title','description','registration_start_date','registration_end_date','activity_start_date','activity_end_date','location','thumbnail','rejection_note'
    ];

    public function organizer() { 
        return $this->belongsTo(Organizer::class); 
    }
}
