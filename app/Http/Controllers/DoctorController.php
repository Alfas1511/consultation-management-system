<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $authUser = auth()->user();
        $my_patient_counts = Appointment::where('doctor_id', $authUser->id)->distinct('patient_id')->count();
        $my_appointments_counts = Appointment::where('doctor_id', $authUser->id)->count();
        $my_total_appointments_completed_counts = Appointment::where('doctor_id', $authUser->id)->where('status', 'completed')->count();
        return view('doctor.dashboard', compact('my_patient_counts', 'my_appointments_counts', 'my_total_appointments_completed_counts', 'authUser'));
    }
}
