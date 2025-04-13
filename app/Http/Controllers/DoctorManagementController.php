<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorAvailabilityStoreRequest;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\DoctorAvailability;
use App\Models\DoctorDepartment;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DoctorManagementController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function list()
    {
        $datas = User::with(['role', 'getDepartment'])->where('role_id', 2);
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('department', function ($data) {
                return $data->getDepartment->getDepartment->name ?? '--';
            })
            ->addColumn('actions', function ($data) {
                $btn = '';
                $btn = '<a class="btn btn-info btn-sm" href="' . route('doctor.availability', $data->id) . '">Doctor Availability</a>';
                $btn .= '<a class="btn btn-sm btn-dark" href="' . route('doctor.edit', $data->id) . '">Edit</a>';
                return $btn;
            })
            ->rawColumns(['department', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::get();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(DoctorStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->username = $data['email'];
            $user->role_id = 2;
            $user->password = Hash::make($data['password']);
            $user->save();
            if ($user->id) {
                DoctorDepartment::create([
                    'doctor_id' => $user->id,
                    'department_id' => $data['department'],
                ]);
            }
            DB::commit();
            return redirect()->route('doctor.index')->with('success', 'Doctor Created Successfully');
        } catch (\Throwable $th) {
            info($th);
            DB::rollBack();
            return redirect()->route('doctor.index')->with('error', 'Something went wrong');
        }
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        $departments = Department::get();
        return view('admin.doctors.edit', compact('departments', 'user'));
    }

    public function update(DoctorUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $user = User::find($id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->username = $data['email'];
            $user->role_id = 2;
            $user->password = Hash::make($data['password']);
            $user->save();

            $doctor_department = DoctorDepartment::where('doctore_id', $user->id)->first();
            $doctor_department->department_id = $data['department'];
            $doctor_department->save();

            DB::commit();
            return redirect()->route('doctor.index')->with('success', 'Doctor Updated Successfully');
        } catch (\Throwable $th) {
            info($th);
            DB::rollBack();
            return redirect()->route('doctor.index')->with('error', 'Something went wrong');
        }
    }

    public function doctorAvailablity(string $id)
    {
        $doctor = User::find($id);
        return view('admin.doctors_availability.index', compact('doctor'));
    }

    public function doctorAvailablityList(Request $request)
    {
        $datas = DoctorAvailability::where('doctor_id', $request->id);
        return DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('doctor', function ($data) {
                return $data->getDoctor->name ?? '--';
            })
            ->addColumn('timeslot', function ($data) {
                $time = $data->start_time;
                $time .= " - ";
                $time .= $data->end_time;
                return $time;
            })
            ->addColumn('actions', function ($data) {
                $btn = '';
                $btn = '<a class="btn btn-info btn-sm" href="' . route('doctor.availability', $data->id) . '">Doctor Availability</a>';
                $btn .= '<a class="btn btn-sm btn-dark" href="' . route('doctor.edit', $data->id) . '">Edit</a>';
                return $btn;
            })
            ->rawColumns(['doctor', 'actions', 'timeslot'])
            ->make(true);
    }

    public function doctorAvailablityCreatePage(string $id)
    {
        $doctor = User::find($id);
        return view('admin.doctors_availability.create', compact('doctor'));
    }

    public function doctorAvailablityStore(DoctorAvailabilityStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $doctorAvailability = new DoctorAvailability();
            $doctorAvailability->doctor_id = $data['id'];
            $doctorAvailability->date = $data['date'];
            $doctorAvailability->day = $data['day'];
            $doctorAvailability->start_time = $data['start_time'];
            $doctorAvailability->end_time = $data['end_time'];
            $doctorAvailability->save();
            DB::commit();
            return redirect()->route('doctor.availability', $data['id'])->with('success', 'Doctor Availability Updated Successfully');
        } catch (\Throwable $th) {
            info($th);
            DB::rollBack();
            return redirect()->route('doctor.availability')->with('error', 'Something went wrong');
        }
    }


}
