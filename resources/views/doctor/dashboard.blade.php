@extends('layouts.mainapp')
@section('title', 'Doctor Dashboard')
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Doctor Dashboard ( {{ $authUser->name }} )</h1>
                </div>
                <!-- PAGE-HEADER END -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">My Patients</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $my_patient_counts }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">My Total Appointments</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $my_appointments_counts }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="fw-normal">My Total Appointments Completed</h6>
                                        <h2 class="mb-0 text-dark fw-semibold">{{ $my_total_appointments_completed_counts }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- CONTAINER END -->
        </div>
    </div>
    <!--app-content close-->
@endsection
