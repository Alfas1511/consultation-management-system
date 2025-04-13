<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorDepartment extends Model
{
    protected $table = 'doctor_departments';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
