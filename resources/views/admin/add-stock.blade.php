@extends('admin.layouts.app')

@section('title', 'Add Branch | Car 4 Sale')


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
                <li class="breadcrumb-item active">Add Lead</li>
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
                <h5 class="card-title">Add Stock</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{url('admin/add-stock')}}" method="POST">
                    @csrf
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Branch</label>
                        <select id="category" class="form-select" name="branch">
                            <option selected value="">Choose...</option>
                            @foreach ($data as $item)
                                <option value="{{ $item->id }}" @selected(old('branch') == $item->id)>{{ $item->branch_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Vehicle Model Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('car_model') }}"
                            name="car_model">
                    </div>

                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Registration Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('reg_number') }}"
                            name="reg_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Engine Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('eng_number') }}"
                            name="eng_number" placeholder="Enter Last 5 Digit" maxlength="5" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Chassis  Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('chassis_number') }}"
                            name="chassis_number" placeholder="Enter Last 5 Digit" maxlength="5" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Model Year <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('car_model_year') }}"
                            name="car_model_year" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Color <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('color') }}"
                            name="color" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Fuel <span style="color: red;">*</span></label>
                        <select id="category" class="form-select" name="fuel_type">
                            <option selected value="">Choose...</option>
                            <option value="CNG">CNG</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Petrol">Petrol+CNG</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Owner Sl No <span style="color: red;">*</span></label>
                        <select id="category" class="form-select" name="owner_sl_no">
                            <option selected>Choose...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Ask Price <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('price') }}"
                            name="price" maxlength="10" required>
                    </div>
                    <div class="col-4">
                        <label for="inputAddress2" class="form-label">Last Price <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="address" name="lastprice"
                            value="{{ old('lastprice') }}" required>
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
