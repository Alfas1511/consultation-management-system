@extends('layouts.mainapp')
@section('title', 'Patients List')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Patients List</h1>
                </div>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif

                <div class="card">
                    <div class="card-body">
                        <table id='table' class="table table-striped table-bordered">
                            <thead>
                                <th width=7%>SI No</th>
                                <th>Patient Name</th>
                                <th>For Doctor</th>
                                <th>Appointment Date</th>
                                <th>Time Slot</th>
                                <th>Status</th>
                                <th width=13%>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                scrollX: false,
                destroy: true,
                lengthChange: true,
                autoWidth: false,
                searching: true,
                stateSave: true,
                ajax: {
                    url: "{{ route('my_patients.list') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'patient_name',
                        name: 'patient_name',
                    },
                    {
                        data: 'for_doctor',
                        name: 'for_doctor',
                    },
                    {
                        data: 'appointment_date',
                        name: 'appointment_date',
                    },
                    {
                        data: 'timeslot',
                        name: 'timeslot',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    }
                ]
            });
        });
    </script>
@endsection
