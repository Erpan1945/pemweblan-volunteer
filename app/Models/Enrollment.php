<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $primaryKey = 'enrollment_id'; // Wajib, jangan pakai 'id'
    public $incrementing = true; // default true, pastikan sesuai tipe
    protected $keyType = 'int'; // default int, pastikan sesuai tipe
    protected $fillable = ['volunteer_id','activity_id','status'];

    public function activity() {
        return $this->belongsTo(Activity::class, 'activity_id', 'activity_id'); 
    }
    
    public function volunteer() {
        return $this->belongsTo(Volunteer::class, 'volunteer_id', 'volunteer_id'); 
    }
}