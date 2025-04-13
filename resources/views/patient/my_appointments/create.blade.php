@extends('layouts.mainapp')
@section('title', 'Create Appointment')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Create Appointment</h1>
                </div>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('appointment.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <label for="doctor">Doctor<span class="text-danger">*</span></label>
                                    <select name="doctor" id="doctor" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="date">Select Date<span class="text-danger">*</span></label>
                                    <select name="date" id="date" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="timeslot">Time Slot<span class="text-danger">*</span></label>
                                    <select name="timeslot" id="timeslot" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-6 mt-2">
                                <button class="btn btn-primary mt-2">Add Appointment</button>
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
            $('#doctor').on('change', function() {
                const doctor_id = $('#doctor').val();
                $('#date').html('<option value="">Select a Date</option>');
                $('#timeslot').html('<option value="">Select a Time Slot</option>');
                if (doctor_id) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('getDoctorAvailabilityDates') }}",
                        data: {
                            doctor_id: doctor_id,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                response.data.forEach(item => {
                                    $('#date').append(
                                        `<option value="${item.date}">${item.date}</option>`
                                    );
                                });
                            } else {
                                $('#date').html('<option value="">No dates available</option>');
                            }
                        },
                        error: function() {
                            $('#date').html('<option value="">Error loading dates</option>');
                        }
                    });
                }
            });

            $('#date').on('change', function() {
                const doctor_id = $('#doctor').val();
                const date = $('#date').val();
                $('#timeslot').html('<option value="">Select a Time Slot</option>');
                if (doctor_id && date) {
                    $.ajax({
                        type: "get",
                        url: "{{ route('getDoctorAvailabilityTimeSlots') }}",
                        data: {
                            doctor_id: doctor_id,
                            date: date,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                response.data.forEach(item => {
                                    $('#timeslot').append(
                                        `<option value="${item.id}">${item.start_time} - ${item.end_time}</option>`
                                    );
                                });
                            } else {
                                $('#timeslot').html(
                                    '<option value="">No slots available</option>');
                            }
                        },
                        error: function() {
                            $('#timeslot').html(
                            '<option value="">Error loading slots</option>');
                        }
                    });
                }
            });
        });
    </script>
@endsection
