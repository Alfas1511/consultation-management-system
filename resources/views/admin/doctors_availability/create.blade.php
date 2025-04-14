@extends('layouts.mainapp')
@section('title', 'Create Doctor Availability')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Create Doctor Availability</h1>
                </div>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif
                
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('doctor.availability.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $doctor->id }}">
                                <div class="col-4">
                                    <label for="name">Doctor Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Doctor Name"
                                        readonly value="{{ $doctor->name }}" />
                                </div>

                                <div class="col-4">
                                    <label for="date">Select Date<span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="dateInput" class="form-control" />
                                </div>

                                <div class="col-4">
                                    <label for="day">Select Day<span class="text-danger">*</span></label>
                                    <select name="day" id="day" class="form-select">
                                        <option value="">All</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="start_time">Start Time<span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control" />
                                </div>


                                <div class="col-4">
                                    <label for="end_time">End Time<span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control" />
                                </div>

                            </div>

                            <div class="col-6 mt-2">
                                <button class="btn btn-primary mt-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dateInput').setAttribute('min', today);
        });
    </script>
@endsection
