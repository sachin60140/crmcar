@extends('admin.layouts.app')

@section('title', 'Car Booking | Car 4 Sale')


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
                <li class="breadcrumb-item active">Add Booking</li>
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
                <h5 class="card-title">Add Booking</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{ url('admin/add-stock') }}" method="POST">
                    @csrf
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Reg Number</label>
                        <select id="category" class="form-select" name="branch">
                            <option selected>Choose...</option>
                            @foreach ($car_stock as $item)
                                <option value="{{ $item->id }}" @selected(old('branch') == $item->id)>{{ $item->reg_number }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Name of Customer <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('cus_name') }}"
                            name="cus_name">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Father's Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('f_name') }}"
                            name="f_name">
                    </div>
                    <div class="col-md-12">
                        <label for="fee" class="form-label">Address <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('address') }}"
                            name="address">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">PS <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('ps') }}"
                            name="ps">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Post <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('post') }}"
                            name="post">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Dist <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="cab_fee" value="{{ old('dist') }}"
                            name="dist">
                    </div>

                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Pin Code <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('pincode') }}"
                            name="pincode" required>
                    </div>

                    <hr>
                    <div class="col-md-4">
                        <label for="total_amount" class="form-label">Total Amount <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="total_amount" value="{{ old('total_amount') }}"
                            name="total_amount" required>
                    </div>
                    <div class="col-md-4">
                        <label for="adv_amount" class="form-label">Advance Amount <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="adv_amount" value="{{ old('adv_amount') }}"
                            name="adv_amount" required>
                    </div>
                    <div class="col-md-4">
                        <label for="due_amount" class="form-label">Due Amount <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="due_amount" value="{{ old('due_amount') }}"
                            name="due_amount" required>
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
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script>
            $(function() {
                $('#total_amount, #adv_amount').keyup(function() {
                    var value1 = parseFloat($('#total_amount').val()) || 0;
                    
                    var value2 = parseFloat($('#adv_amount').val()) || 0;
                    $('#due_amount').val(value1 - value2);
                });
            });
        </script>



    @endsection
