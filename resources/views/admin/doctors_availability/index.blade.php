@extends('layouts.mainapp')
@section('title', 'Doctor Availability Chart')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Doctor Availability Chart</h1>
                    <div class="prism-toggle px-2">
                        <a href="{{ route('doctor.availability.create', $doctor->id) }}"><button
                                class="btn btn-primary">Update
                                Availability</button></a>
                    </div>
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
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time-Slot</th>
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
                    url: "{{ route('doctor.availability.list') }}",
                    data: {
                        id: {{ $doctor->id }},
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'doctor',
                        name: 'doctor',
                    },
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data: 'day',
                        name: 'day',
                    },
                    {
                        data: 'timeslot',
                        name: 'timeslot',
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
