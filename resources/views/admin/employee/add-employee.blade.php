@extends('admin.layouts.app')

@section('title', 'Add Employee | Car 4 Sale')

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
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Employee Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active">Add Employee</li>
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
                        <h5 class="card-title">Employee Details</h5>

                        <form class="row g-3" action="{{ route('inserempdata') }}" method="POST">
                            @csrf
                            
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="{{ old('name') }}" placeholder="Enter full name" required>
                            </div>

                            {{-- Mobile --}}
                            <div class="col-md-6">
                                <label for="emp_mobile" class="form-label">Mobile Number <span class="required-star">*</span></label>
                                <input type="tel" class="form-control" id="emp_mobile" name="emp_mobile" 
                                    value="{{ old('emp_mobile') }}" placeholder="e.g. 0123456789" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="required-star">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="{{ old('email') }}" placeholder="name@example.com" required>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password <span class="required-star">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            {{-- Cloud Calling Number --}}
                            <div class="col-md-12">
                                <label for="cloud_calling_number" class="form-label">Cloud Calling Number</label>
                                <input type="text" class="form-control" id="cloud_calling_number" 
                                    value="{{ old('cloud_calling_number') }}" name="cloud_calling_number">
                            </div>

                            <hr class="my-3">

                            {{-- User Type (Admin/Salesman) --}}
                            <div class="col-md-6">
                                <label for="user_type" class="form-label">User Role <span class="required-star">*</span></label>
                                <select name="user_type" id="user_type" class="form-select" required>
                                    <option value="" selected disabled>Choose Role...</option>
                                    <option value="1" {{ old('user_type') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>Salesman</option>
                                </select>
                            </div>

                            {{-- Branch --}}
                            <div class="col-md-6">
                                <label for="branch" class="form-label">Assigned Branch <span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="branch" name="branch" 
                                    value="{{ old('branch') }}" placeholder="e.g. Main Branch" required>
                            </div>

                            <div class="text-end mt-4">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary px-4">Create Employee</button>
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
    <script>
        // Placeholder for future logic (e.g., dynamic branch loading)
        $(document).ready(function() {
            // Logic can be added here
        });
    </script>
@endsection