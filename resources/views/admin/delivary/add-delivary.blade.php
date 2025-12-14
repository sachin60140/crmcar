@extends('admin.layouts.app')

@section('title', 'Update Stock | Car 4 Sale')

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
            <li class="breadcrumb-item active">Add Delivery Details</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div>
        @if ($errors->any())
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('success'))
        <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('error'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

    <form action="{{route('insertdelivary')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">
                <i class="bi bi-person-badge me-1"></i> Customer & Vehicle Details
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small">Booking Number</label>
                        <input type="text" readonly class="form-control bg-light" name="booking_id" value="{{$carbooking['0']['booking_no']}}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small">Booking Date</label>
                        <input type="text" readonly class="form-control bg-light" name="booking_date" value="{{date('d-M-Y', strtotime($carbooking['0']['created_at'])) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Booking Person</label>
                        <input type="text" readonly class="form-control bg-light" name="booking_person" value="{{$carbooking['0']['booking_person']}}">
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="col-md-4">
                        <label class="form-label">Customer Name</label>
                        <input type="text" readonly class="form-control bg-light" name="name" value="{{$carbooking['0']['name']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Father's Name</label>
                        <input type="text" readonly class="form-control bg-light" name="father_name" value="{{$carbooking['0']['father']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" readonly class="form-control bg-light" name="mobile" value="{{$carbooking['0']['mobile']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Aadhar Number</label>
                        <input type="text" readonly class="form-control bg-light" name="aadhar" value="{{$carbooking['0']['aadhar']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">PAN Card</label>
                        <input type="text" readonly class="form-control bg-light" name="pan_card" value="{{$carbooking['0']['pan']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" readonly class="form-control bg-light" name="city" value="{{$carbooking['0']['city']}}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input type="text" readonly class="form-control bg-light" name="address" value="{{$carbooking['0']['address']}}">
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="col-md-3">
                        <label class="form-label">Registration No.</label>
                        <input type="text" readonly class="form-control bg-light fw-bold" name="reg_number" value="{{$carbooking['0']['regnumber']}}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Model Name</label>
                        <input type="text" readonly class="form-control bg-light" name="model_name" value="{{$carbooking['0']['carmodel']}}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Model Year</label>
                        <input type="text" readonly class="form-control bg-light" name="model_year" value="{{$carbooking['0']['model_year']}}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Owner Serial No.</label>
                        <input type="text" readonly class="form-control bg-light" name="owner_sl_no" value="{{$carbooking['0']['owner_sl_no']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Color</label>
                        <input type="text" readonly class="form-control bg-light" name="car_color" value="{{$carbooking['0']['car_color']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Engine Number</label>
                        <input type="text" readonly class="form-control bg-light" name="eng_number" value="{{$carbooking['0']['engnum']}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Chassis Number</label>
                        <input type="text" readonly class="form-control bg-light" name="chassis_number" value="{{$carbooking['0']['chassis_number']}}">
                    </div>
                </div>
            </div>
        </div>

      

      <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-currency-rupee me-1"></i> Payment Details
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sell Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" readonly class="form-control bg-light" id="sell_amount" name="sell_amount" 
                               value="{{ old('sell_amount', $carbooking['0']['total_amount']) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Adv. Booking Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" readonly class="form-control bg-light" id="booking_amount" name="booking_amount" 
                               value="{{ old('booking_amount', $carbooking['0']['adv_amount']) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Finance Amount <span class="text-danger">*</span></label>
                        <input type="number"  class="form-control" id="finance_amount" name="finance_amount" 
                               value="{{ old('finance_amount', $carbooking['0']['finance_amount']) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Down Payment <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control bg-warning bg-opacity-10 fw-bold" id="dp" name="dp" 
                               value="{{ old('dp', $carbooking['0']['due_amount']) }}" readonly>
                        <small class="text-muted" style="font-size: 0.75rem;">(Sell - Advance - Finance)</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Payment Mode</label>
                        <select class="form-select" name="paymentMode">
                            <option value="">Select Mode...</option>
                            <option value="Cash" {{ old('paymentMode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Cash+UPI" {{ old('paymentMode') == 'Cash+UPI' ? 'selected' : '' }}>Cash+UPI</option>
                            <option value="UPI" {{ old('paymentMode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Neft" {{ old('paymentMode') == 'Neft' ? 'selected' : '' }}>NEFT</option>
                            <option value="RTGS" {{ old('paymentMode') == 'RTGS' ? 'selected' : '' }}>RTGS</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Select Financer</label>
                        <select class="form-select" name="financer">
                            <option value="">Select Financer...</option>
                            @foreach ($financer as $item)
                            <option value="{{$item->financer_name}}" {{ old('financer') == $item->financer_name ? 'selected' : '' }}>
                                {{$item->financer_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Delivery Remarks</label>
                        <textarea class="form-control" id="remarks" rows="2" name="remarks">{{ old('remarks') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-clipboard-check me-1"></i> Pre-Delivery Inspection (PDI) Report
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Electrical Work <span class="text-danger">*</span></label>
                        <select class="form-select" name="electricle_work">
                            <option value="">Select Status...</option>
                            <option value="All OK" {{ old('electricle_work') == 'All OK' ? 'selected' : '' }}>All OK</option>
                            <option value="Not OK" {{ old('electricle_work') == 'Not OK' ? 'selected' : '' }}>Not OK</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">AC Condition <span class="text-danger">*</span></label>
                        <select class="form-select" name="ac_work_status">
                            <option value="">Select Status...</option>
                            <option value="Working" {{ old('ac_work_status') == 'Working' ? 'selected' : '' }}>Working</option>
                            <option value="Not Working" {{ old('ac_work_status') == 'Not Working' ? 'selected' : '' }}>Not Working</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Suspension <span class="text-danger">*</span></label>
                        <select class="form-select" name="suspenstion_status">
                            <option value="">Select Status...</option>
                            <option value="All OK" {{ old('suspenstion_status') == 'All OK' ? 'selected' : '' }}>All OK</option>
                            <option value="Not OK" {{ old('suspenstion_status') == 'Not OK' ? 'selected' : '' }}>Not OK</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Engine Condition <span class="text-danger">*</span></label>
                        <select class="form-select" name="engine_status">
                            <option value="">Select Status...</option>
                            <option value="Good" {{ old('engine_status') == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Very Good" {{ old('engine_status') == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                            <option value="Excellent" {{ old('engine_status') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Starting <span class="text-danger">*</span></label>
                        <select class="form-select" name="starting_status">
                            <option value="">Select Status...</option>
                            <option value="Normal" {{ old('starting_status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Long Start" {{ old('starting_status') == 'Long Start' ? 'selected' : '' }}>Long Start</option>
                            <option value="Not Starting" {{ old('starting_status') == 'Not Starting' ? 'selected' : '' }}>Not Starting</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Stepny <span class="text-danger">*</span></label>
                        <select class="form-select" name="stepny_status">
                            <option value="">Select Status...</option>
                            <option value="Available" {{ old('stepny_status') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Not Available" {{ old('stepny_status') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jack, Wrench, Pana <span class="text-danger">*</span></label>
                        <select class="form-select" name="tools_kit_status">
                            <option value="">Select Status...</option>
                            <option value="Available" {{ old('tools_kit_status') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Not Available" {{ old('tools_kit_status') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Inspection By <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="inspection_by" value="{{ old('inspection_by') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Upload PDI Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="pdi_image">
                        </div>
                    <div class="col-md-6">
                        <label class="form-label">PDI Remarks</label>
                        <textarea class="form-control" rows="1" name="pdi_remarks">{{ old('pdi_remarks') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <button type="submit" class="btn btn-lg btn-success px-5">
                <i class="bi bi-check-circle-fill"></i> Submit Delivery Details
            </button>
        </div>

    </form>
</section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Function to calculate Down Payment
        function calculateDownPayment() {
            var sellAmount = parseFloat($('#sell_amount').val()) || 0;
            var bookingAmount = parseFloat($('#booking_amount').val()) || 0;
            var financeAmount = parseFloat($('#finance_amount').val()) || 0;

            var remaining = sellAmount - bookingAmount;
            var downPayment = remaining - financeAmount;

            // Update the Down Payment field
            $('#dp').val(downPayment.toFixed(2)); // Keeping 2 decimal places
        }

        // Trigger calculation when any relevant field changes
        $('#sell_amount, #booking_amount, #finance_amount').on('keyup change', function() {
            calculateDownPayment();
        });

        // Run once on page load to set initial values
        calculateDownPayment();
    });
</script>
@endsection