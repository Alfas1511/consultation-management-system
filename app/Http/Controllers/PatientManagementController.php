<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
        $datas = Appointment::where('doctor_id', $authUser->id);
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($data) {
                return $data->getPatient->name ?? "--";
            })
            ->addColumn('actions', function ($data) {
                $btn = '';
                $btn = '<a class="btn btn-info btn-sm" href="#">Update Status</a>';
                return $btn;
            })
            ->rawColumns(['patient_name', 'actions'])
            ->make(true);
    }
}
