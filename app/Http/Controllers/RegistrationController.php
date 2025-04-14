<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationStoreRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function registrationPage()
    {
        return view('auth.register');
    }

    public function register(RegistrationStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->username = $data['email'];
            $user->role_id = 3;
            $user->password = Hash::make($data['password']);
            $user->save();

            return redirect()->route('loginPage')->with('success', 'Registration Successfull. Please login to continue');
        } catch (\Throwable $th) {
            info($th);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
