@extends('admin.layouts.app')

@section('title', 'Update Stock | Car 4 Sale')


@section('style')

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input:read-only {
  background-color: rgb(222, 222, 222);
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
                <li class="breadcrumb-item active">Add Delivary Details</li>
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
                <h5 class="card-title">Add Delivary Details</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{route('insertdelivary')}}" method="POST">
                    @csrf
                    <div class="col-md-3">
                        <label for="fee" class="form-label">Booking Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="booking_id" value="{{$carbooking['0']['booking_no']}}"
                            name="booking_id">
                    </div>

                    <div class="col-md-3">
                        <label for="fee" class="form-label">Booking Date <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="booking_date" value="{{date('d-M-Y', strtotime($carbooking['0']['created_at'])) }}"
                            name="booking_date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fee" class="form-label">Booking Person <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="booking_person" value="{{$carbooking['0']['booking_person']}}"
                            name="booking_person">
                    </div>
                    <hr>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Customer Name <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="name" value="{{$carbooking['0']['name']}}"
                            name="name">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Father's Name <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="father_name" value="{{$carbooking['0']['father']}}"
                            name="father_name">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Mobile Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="mobile" value="{{$carbooking['0']['mobile']}}"
                            name="mobile">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Aadhar Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="aadhar" value="{{$carbooking['0']['aadhar']}}"
                            name="aadhar">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Pan Card <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="pan_card" value="{{$carbooking['0']['pan']}}"
                            name="pan_card">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">City<span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="city" value="{{$carbooking['0']['city']}}"
                            name="city">
                    </div>
                    <div class="col-md-12">
                        <label for="fee" class="form-label">Address <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="address" value="{{$carbooking['0']['address']}}"
                            name="address">
                    </div>

                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Registration Number <span 
                                style="color: red;">*</span></label>
                        <input type="Text" readonly class="form-control" id="reg_number" value="{{$carbooking['0']['regnumber']}}"
                            name="reg_number" required>
                    </div>
                     <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Model Name <span 
                                style="color: red;">*</span></label>
                        <input type="Text" readonly class="form-control" id="model_name" value="{{$carbooking['0']['carmodel']}}"
                            name="model_name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Model Year <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="model_year" value="{{$carbooking['0']['model_year']}}"
                            name="model_year">
                    </div>
                    <div class="col-md-3">
                        <label for="fee" class="form-label">Owner Sl No. <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="owner_sl_no" value="{{$carbooking['0']['owner_sl_no']}}"
                            name="owner_sl_no">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Colour <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="car_color" value="{{$carbooking['0']['car_color']}}"
                            name="car_color">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Engine Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="eng_number" value="{{$carbooking['0']['engnum']}}"
                            name="eng_number">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Chassis Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="chassis_number" value="{{$carbooking['0']['chassis_number']}}"
                            name="chassis_number">
                    </div>
                    <hr>
                    
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Sell Amount <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="sell_amount" value="{{$carbooking['0']['total_amount']}}"
                            name="sell_amount">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Advance Booking Amount <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="booking_amount" value="{{$carbooking['0']['adv_amount']}}"
                            name="booking_amount">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Finance Amount <span style="color: red;">*</span></label>
                        <input type="text"  class="form-control" id="finance_amount" value="{{$carbooking['0']['finance_amount']}}"
                            name="finance_amount">
                    </div>
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Down Payment <span style="color: red;">*</span></label>
                        <input type="text"  class="form-control" id="dp" value="{{$carbooking['0']['due_amount']}}"
                            name="dp">
                    </div>
                    <div class="col-md-4">
                        <label for="paymentMode" class="form-label">Payment Mode</label>
                        <select class="form-select" name="paymentMode">
                            <option>Select Payment Mode...</option>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Neft">NEFT</option>
                            <option value="RTGS">RTGS</option>
                        </select>
                    </div>
                    <div class="col-md-12  mb-5">
                        <label for="total_amount" class="form-label">Delivary Remark's </label>
                        <input type="text" class="form-control" id="remarks" rows="2" value="{{ old('remarks') }}" name="remarks"></textarea>
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

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script>
            $(function() {
                $('#sell_amount, #booking_amount, #finance_amount').keyup(function() {
                    var value1 = parseFloat($('#sell_amount').val()) || 0;

                    var value2 = parseFloat($('#booking_amount').val()) || 0;

                    var value3 = parseFloat($('#finance_amount').val()) || 0;

                    var tot = value1 - value2;

                    $('#dp').val(tot - value3 );
                });
            });
        </script>

    @endsection
