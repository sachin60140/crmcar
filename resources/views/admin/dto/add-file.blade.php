@extends('admin.layouts.app')

@section('title', 'Add File | Car 4 Sale')


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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">DTO</li>
                <li class="breadcrumb-item active">Add File</li>
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
                <h5 class="card-title">Add DTO File</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{url('admin/add-stock')}}" method="POST">
                    @csrf
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Registration Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('reg_number') }}"
                            name="reg_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">DTO <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('eng_number') }}"
                            name="eng_number" placeholder="Enter Location" maxlength="5" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Vendor Name <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('chassis_number') }}"
                            name="chassis_number" placeholder="Enter Vendor Name" maxlength="5" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Vendor Mobile <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('car_model_year') }}"
                            name="car_model_year" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Dispatch Date <span style="color: red;">*</span></label>
                        <input type="date" class="form-control" id="inputName5" value="{{ old('color') }}"
                            name="color" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Status <span style="color: red;">*</span></label>
                        <select id="category" class="form-select" name="fuel_type">
                            <option value="" selected>Choose...</option>
                            <option value="Ready to Dispatch">Ready to Dispatch</option>
                            <option value="Dispatched">Dispatched</option>
                            <option value="Online">Online</option>
                            
                        </select>
                    </div>
                   
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Remarks <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="remarks" name="remarks"
                            value="{{ old('remarks') }}" required>
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
