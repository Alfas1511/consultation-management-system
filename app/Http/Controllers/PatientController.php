<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dashboard()
    {
        $authUser = auth()->user();
        $my_appointments_counts = Appointment::where('patient_id', $authUser->id)->count();
        $my_completed_appointments_counts = Appointment::where('patient_id', $authUser->id)->where('status', 'completed')->count();
        return view('patient.dashboard', compact('my_appointments_counts', 'my_completed_appointments_counts', 'authUser'));
    }
}
