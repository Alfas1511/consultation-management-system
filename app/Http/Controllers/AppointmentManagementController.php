<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentStoreRequest;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\User;
use DB;
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
        $datas = Appointment::when($authUser->role->id == 3, function ($query) use ($authUser) {
            $query->where('patient_id', $authUser->id);
        });
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('doctor_name', function ($data) {
                return $data->getDoctor->name ?? "--";
            })
            ->addColumn('timeslot', function ($data) {
                return $data->getDoctorAvailability->start_time . "-" . $data->getDoctorAvailability->end_time ?? "--";
            })
            ->addColumn('actions', function ($data) {
                if ($data->status == 'pending') {
                    $btn = '<button class="btn btn-sm btn-warning update-status-btn"
                                data-id="' . $data->id . '"
                                data-status="' . $data->status . '"
                                data-bs-toggle="modal"
                                data-bs-target="#statusModal">
                                Update Status
                        </button>';
                    return $btn;
                }
                return $btn = '';
            })
            ->rawColumns(['doctor_name', 'actions', 'timeslot'])
            ->make(true);
    }

    public function create()
    {
        $doctors = User::where('role_id', 2)->get();
        return view('patient.my_appointments.create', compact('doctors'));
    }

    public function getDoctorAvailabilityDates(Request $request)
    {
        $doctor_availabilities = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('is_available', 1)
            ->select('date')
            ->distinct()
            ->get();
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

    public function store(AppointmentStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $appointment = new Appointment();
            $appointment->doctor_id = $data['doctor'];
            $appointment->patient_id = auth()->id();
            $appointment->availability_id = $data['timeslot'];
            $appointment->appointment_date = $data['date'];
            $appointment->status = 'pending';
            $appointment->save();

            $docAvailability = DoctorAvailability::find($appointment->availability_id);
            $docAvailability->is_available = 0;
            $docAvailability->save();

            DB::commit();
            return redirect()->route('my_appointments.index')->with('success', 'Appointment created Successfully');
        } catch (\Throwable $th) {
            info($th);
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
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

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
