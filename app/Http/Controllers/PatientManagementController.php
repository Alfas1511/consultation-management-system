<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PatientManagementController extends Controller
{
    public function index()
    {
        return view('doctor.my_patients.index');
    }

    public function list(Request $request)
    {
        $authUser = auth()->user();
        $datas = Appointment::when($authUser->role->id == 2, function ($query) use ($authUser) {
            $query->where('doctor_id', $authUser->id);
        });
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($data) {
                return $data->getPatient->name ?? "--";
            })
            ->addColumn('for_doctor', function ($data) {
                return $data->getDoctor->name ?? "--";
            })
            ->addColumn('timeslot', function ($data) {
                return $data->getDoctorAvailability->start_time . "-" . $data->getDoctorAvailability->end_time ?? "--";
            })
            ->addColumn('actions', function ($data) {
                if ($data->status == 'pending') {
                    $btn = '<a class="btn btn-sm btn-info" href="' . route('patient.updateActionPage', $data->id) . '">Update Status</a>';
                    return $btn;
                }
                return $btn = "";
            })
            ->rawColumns(['patient_name', 'actions', 'timeslot', 'for_doctor'])
            ->make(true);
    }

    public function actionsPage(string $id)
    {
        $appointment = Appointment::find($id);
        return view('doctor.my_patients.actions', compact('appointment'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        try {
            $appointment = Appointment::findOrFail($request->appointment_id);
            $appointment->status = $request->status;
            $appointment->save();

            $docAvailability = DoctorAvailability::find($appointment->availability_id);
            $docAvailability->is_available = 1;
            $docAvailability->save();

            return response()->route('my_patients.index')->with('success', ' Status Updated Successfully');
        } catch (\Throwable $th) {
            info($th);
            return response()->route('my_patients.index')->with('error', ' Something went wrong');
        }
    }
}
