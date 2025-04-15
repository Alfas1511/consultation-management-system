<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $authUser = auth()->user();
        $total_doctor_counts = User::where('role_id', 2)->count();
        $total_patient_counts = User::where('role_id', 3)->count();
        $total_appointments_counts = Appointment::count();
        $total_appointments_completed_counts = Appointment::where('status', 'completed')->count();
        return view('admin.dashboard', compact('authUser', 'total_doctor_counts', 'total_patient_counts', 'total_appointments_counts', 'total_appointments_completed_counts'));
    }
}
