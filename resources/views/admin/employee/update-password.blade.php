@extends('admin.layouts.app')

@section('title', 'Update Employee | Car 4 Sale')


@section('style')

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item active">Users</li>
                <li class="breadcrumb-item active">Edit Users</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div>
            @if ($errors->any())
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit User</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{url('admin/edit-employee/'.$user_data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" style="background-color: #8d9797;" readonly id="name" value="{{ $user_data->name}}"
                            name="name">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="email" class="form-label">Login Email ID <span
                                style="color: red;">*</span></label>
                        <input type="email" class="form-control" id="email" style="background-color: #8d9797;" readonly value="{{ $user_data->email }}"
                            name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Login Email ID <span
                                style="color: red;">*</span></label>
                        <input type="email" class="form-control" id="email" style="background-color: #8d9797;" readonly value="{{ $user_data->email }}"
                            name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Cloud Calling Number </label>
                        <input type="text" class="form-control" id="cloud_calling_number" value="{{ $user_data->cloud_calling_number }}"
                            name="cloud_calling_number" >
                    </div>
                    <div class="col-4">
                        <label for="update_password" class="form-label">New Password</label>
                        <input type="text" class="form-control" id="password" name="password" >
                    </div>
                    <div class="col-4">
                        <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" >
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        
                    </div>
                </form>

            </div>
        </div>



        </div>
    @endsection

    @section('script')
    @endsection
