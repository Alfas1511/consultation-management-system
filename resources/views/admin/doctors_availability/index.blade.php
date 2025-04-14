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

                <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">Update Appointment Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="statusUpdateForm">
                                <div class="modal-body">
                                    <input type="hidden" name="appointment_id" id="appointment_id">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="pending">Pending</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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

            $('.update-status-btn').on('click', function() {
                console.log(1);
                var appointmentId = $(this).data('id');
                var currentStatus = $(this).data('status');

                $('#appointment_id').val(appointmentId);
                $('#status').val(currentStatus);
                $('#statusModal').modal('show');
            });

            // Handle form submission
            $('#statusUpdateForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('patient.update_status') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#statusModal').modal('hide');
                            table.ajax.reload();
                            alert(response
                                .message); // Replace with a better notification if needed
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while updating the status.');
                    }
                });
            });
        });
    </script>
@endsection
