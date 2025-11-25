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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <div class="row">
            <div class="col-md-6 mx-auto">
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
                        <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">
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
                        <form class="row g-3" action="{{ route('storebooking') }}" method="POST">
                            @csrf
                            <div class="col-md-12 mb-3" >
                                <label for="category" class="form-label">Reg Number</label>
                                <select id="reg_number" class="form-select" name="reg_number">
                                    <option selected>Choose...</option>
                                    @foreach ($car_stock as $item)
                                        <option value="{{ $item->id }}" @selected(old('reg_number') == $item->id)>
                                            {{ $item->reg_number }}- {{ $item->car_model }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Booking Person<span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="booking_person"
                                    value="{{ old('booking_person') }}" name="booking_person" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="category" class="form-label">Customer</label>
                                <select id="category" class="form-select" name="customer">
                                    <option selected value="">Choose...</option>
                                    @foreach ($ledger as $item)
                                        <option value="{{ $item->id }}" @selected(old('customer') == $item->id)>{{ $item->id }} - {{ $item->name }} - {{ $item->mobile_number }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            
                            <hr>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Sell Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="total_amount"
                                    value="{{ old('total_amount') }}" name="total_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="adv_amount" class="form-label">Advance Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="adv_amount" value="{{ old('adv_amount') }}"
                                    name="adv_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="finance_amount" class="form-label">Finance Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="finance_amount" value="{{ old('finance_amount') }}"
                                    name="finance_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="dp" class="form-label">Down Payment Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="dp" value="{{ old('dp') }}"
                                    name="dp" required>
                            </div>
                            
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Payment Mode</label>
                                <select class="form-select" name="paymentMode">
                                    <option>Select Payment Mode...</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Neft">NEFT</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Booking Remark's </label>
                                <textarea class="form-control" id="remarks" rows="2" value="{{ old('remarks') }}" name="remarks"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection

    @section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script>
            $(function() {
                $('#total_amount, #adv_amount, #finance_amount').keyup(function() {
                    var value1 = parseFloat($('#total_amount').val()) || 0;

                    var value2 = parseFloat($('#adv_amount').val()) || 0;

                    var value3 = parseFloat($('#finance_amount').val()) || 0;

                    var tot = value1 - value2;

                    $('#dp').val(tot - value3 );
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('#reg_number').select2();
            });
        </script>



    @endsection
