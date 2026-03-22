@extends('admin.layouts.app')

@section('title', 'Update Employee | Car 4 Sale')

@section('style')
    <style>
        /* Remove arrows from number inputs */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
        .form-label { font-weight: 600; }
        .required-star { color: red; }
        /* Style for readonly fields to indicate they aren't editable if needed */
        .form-control[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Employee Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Edit Employee</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                
                {{-- Alert Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success border-0 alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Edit Employee: {{ $user_data->name }}</h5>

                        <form class="row g-3" action="{{ url('admin/edit-employee/'.$user_data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="{{ old('name', $user_data->name) }}" required>
                            </div>

                            {{-- Mobile --}}
                            <div class="col-md-6">
                                <label for="emp_mobile" class="form-label">Mobile Number <span class="required-star">*</span></label>
                                <input type="tel" class="form-control" id="emp_mobile" name="emp_mobile" 
                                    value="{{ old('emp_mobile', $user_data->emp_mobile) }}" required>
                            </div>

                            {{-- Email (Readonly if you don't want them changing login ID) --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address (Login ID) <span class="required-star">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="{{ old('email', $user_data->email) }}" readonly>
                            </div>

                            {{-- Cloud Calling Number --}}
                            <div class="col-md-6">
                                <label for="cloud_calling_number" class="form-label">Cloud Calling Number</label>
                                <input type="text" class="form-control" id="cloud_calling_number" 
                                    name="cloud_calling_number" value="{{ old('cloud_calling_number', $user_data->cloud_calling_number) }}">
                            </div>

                            <hr class="my-3">

                            {{-- User Type --}}
                            <div class="col-md-6">
                                <label for="user_type" class="form-label">User Role <span class="required-star">*</span></label>
                                <select name="user_type" id="user_type" class="form-select" required>
                                    <option value="1" {{ old('user_type', $user_data->user_type) == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('user_type', $user_data->user_type) == '2' ? 'selected' : '' }}>Salesman</option>
                                </select>
                            </div>

                            {{-- Branch --}}
                            <div class="col-md-6">
                                <label for="branch" class="form-label">Assigned Branch <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="branch" name="branch" 
                                    value="{{ old('branch', $user_data->branch) }}" required>
                            </div>

                            <hr class="my-3">
                            <p class="text-muted small">Leave password fields blank if you don't want to change the password.</p>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="********">
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********">
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ url('admin/view-employee') }}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Update Employee</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@endsection