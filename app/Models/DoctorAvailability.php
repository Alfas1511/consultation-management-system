<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    protected $table = 'doctor_availabilities';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getDoctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
}
