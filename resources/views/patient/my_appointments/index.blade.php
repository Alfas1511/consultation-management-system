@extends('layouts.mainapp')
@section('title', 'My Appointments List')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">My Appointments List</h1>
                    <div class="prism-toggle px-2">
                        <a href="{{ route('appointment.create') }}"><button class="btn btn-primary">Create
                                Appointment</button></a>
                    </div>
                </div>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif


                <!-- Status Update Modal -->
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
                                    <input type="hidden" id="appointment_id" name="appointment_id">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="pending" disabled>Pending</option>
                                            {{-- <option value="completed">Completed</option> --}}
                                            <option value="cancelled">Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="saveStatusBtn">Save Changes</button>
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
                                <th>Appointment Date</th>
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
                    url: "{{ route('my_appointments.list') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name',
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

            $(document).on('click', '.update-status-btn', function() {
                var appointmentId = $(this).data('id');
                var currentStatus = $(this).data('status');

                $('#appointment_id').val(appointmentId);
                $('#status').val(currentStatus);
            });

            // Handle form submission
            $('#statusUpdateForm').on('submit', function(e) {
                e.preventDefault();

                var appointmentId = $('#appointment_id').val();
                var status = $('#status').val();
                var saveBtn = $('#saveStatusBtn');

                saveBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('appointment.update_status') }}",
                    type: 'POST',
                    data: {
                        appointment_id: appointmentId,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload(null, false);
                            $('#statusModal').modal('hide');
                            alert('Status updated successfully!');
                        } else {
                            alert('Failed to update status: ' + (response.message ||
                                'Unknown error'));
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON?.message || 'Something went wrong');
                    },
                    complete: function() {
                        saveBtn.prop('disabled', false).text('Save Changes');
                    }
                });
            });
        });
    </script>
@endsection
