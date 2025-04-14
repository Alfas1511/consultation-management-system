<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getDoctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function getPatient()
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function getDoctorAvailability()
    {
        return $this->belongsTo(DoctorAvailability::class, 'availability_id', 'id');
    }
}
