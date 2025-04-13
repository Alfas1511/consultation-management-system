<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppointmentManagementController extends Controller
{
    public function index()
    {
        return view('patient.my_appointments.index');
    }

    public function list(Request $request)
    {
        $authUser = auth()->user();
        $datas = Appointment::where('patient_id', $authUser->id);
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('doctor_name', function ($data) {
                return $data->getDoctor->name ?? "--";
            })
            ->addColumn('actions', function ($data) {
                $btn = '';
                $btn = '<a class="btn btn-info btn-sm" href="#">Update Status</a>';
                return $btn;
            })
            ->rawColumns(['doctor_name', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $doctors = User::where('role_id', 2)->get();
        return view('patient.my_appointments.create', compact('doctors'));
    }

    public function getDoctorAvailabilityDates(Request $request)
    {
        $doctor_availabilities = DoctorAvailability::where('doctor_id', $request->doctor_id)->get();
        return response()->json([
            'status' => true,
            'data' => $doctor_availabilities,
        ]);
    }

    public function getDoctorAvailabilityTimeSlots(Request $request)
    {
        $doctor_availabilities = DoctorAvailability::where('doctor_id', $request->doctor_id)->where('date', $request->date)->get();
        return response()->json([
            'status' => true,
            'data' => $doctor_availabilities,
        ]);
    }
}
