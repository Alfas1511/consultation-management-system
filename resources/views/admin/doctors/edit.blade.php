@extends('layouts.mainapp')
@section('title', 'Edit Doctor')
@section('content')
    <div class="main-content app-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="page-header">
                    <h1 class="page-title">Edit Doctor</h1>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('doctor.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-4">
                                    <label for="name">Doctor Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Doctor Name"
                                        value="{{ $user->name }}" />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <label for="email">Doctor Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Doctor Email"
                                        value="{{ $user->email }}" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <label for="department">Doctor Department<span class="text-danger">*</span></label>
                                    <select name="department" id="department" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                @if ($department->id == $user->getDepartment->department_id) selected @endif>
                                                {{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6 mt-2">
                                <button class="btn btn-primary mt-2">Update Doctor</button>
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

        });
    </script>
@endsection
