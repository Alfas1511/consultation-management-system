@extends('layouts.mainapp')
@section('title', 'Update Patient Status')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Update Patient Status</h1>
                </div>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('patient.update_status') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                <div class="col-4">
                                    <label for="name">Doctor Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Doctor Name"
                                        readonly value="{{ $appointment->getDoctor->name }}" />
                                </div>

                                <div class="col-4">
                                    <label for="status">Status<span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" @if ($appointment->status == 'pending') selected @endif>Pending
                                        </option>
                                        <option value="completed" @if ($appointment->status == 'completed') selected @endif>
                                            Completed</option>
                                        {{-- <option value="cancelled">Cancelled</option> --}}
                                    </select>
                                </div>

                            </div>

                            <div class="col-6 mt-2">
                                <button class="btn btn-primary mt-2">Update</button>
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
                        data: 'appointment_date',
                        name: 'appointment_date',
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
