@extends('admin.layouts.app')

@section('title', 'Car Booking | Car 4 Sale')

@section('style')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* Hide HTML5 Up/Down arrows for number inputs */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield; /* Firefox */
        }
        
        /* Optional: Fix Select2 height to match Bootstrap inputs */
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 5px;
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
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-8 mx-auto"> {{-- Increased width slightly for better spacing --}}
                
                {{-- Alert Messages --}}
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

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Booking</h5>

                        <form class="row g-3" action="{{ route('storebooking') }}" method="POST">
                            @csrf
                            
                            {{-- Vehicle Selection --}}
                            <div class="col-md-12">
                                <label for="reg_number" class="form-label">Reg Number</label>
                                <select id="reg_number" class="form-select select2-enable" name="reg_number">
                                    <option selected value="">Choose Vehicle...</option>
                                    @foreach ($car_stock as $item)
                                        <option value="{{ $item->id }}" @selected(old('reg_number') == $item->id)>
                                            {{ $item->reg_number }} - {{ $item->car_model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Booking Person --}}
                            <div class="col-md-6">
                                <label for="booking_person" class="form-label">Booking Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="booking_person" name="booking_person" value="{{ old('booking_person') }}" required>
                            </div>

                            {{-- Customer Selection --}}
                            <div class="col-md-6">
                                <label for="customer" class="form-label">Customer</label>
                                <select id="customer" class="form-select select2-enable" name="customer">
                                    <option selected value="">Choose Customer...</option>
                                    @foreach ($ledger as $item)
                                        <option value="{{ $item->id }}" @selected(old('customer') == $item->id)>
                                            {{ $item->id }} - {{ $item->name }} - {{ $item->mobile_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <hr class="mt-4">
                            <h6 class="text-muted">Payment Details</h6>

                            {{-- Amount Fields - Row 1 --}}
                            <div class="col-md-6">
                                <label for="total_amount" class="form-label">Sell Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="any" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="adv_amount" class="form-label">Advance Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="any" class="form-control" id="adv_amount" name="adv_amount" value="{{ old('adv_amount') }}" required>
                                </div>
                            </div>

                            {{-- Amount Fields - Row 2 --}}
                            <div class="col-md-6">
                                <label for="finance_amount" class="form-label">Finance Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="any" class="form-control" id="finance_amount" name="finance_amount" value="{{ old('finance_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="dp" class="form-label">Down Payment (Auto) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    {{-- Added readonly to prevent manual editing since it is calculated --}}
                                    <input type="number" step="any" class="form-control bg-light" id="dp" name="dp" value="{{ old('dp') }}" readonly required>
                                </div>
                            </div>
                            
                            {{-- Payment Mode --}}
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Payment Mode</label>
                                <select class="form-select" id="paymentMode" name="paymentMode">
                                    <option value="">Select Payment Mode...</option>
                                    <option value="Cash" @selected(old('paymentMode') == 'Cash')>Cash</option>
                                    <option value="UPI" @selected(old('paymentMode') == 'UPI')>UPI</option>
                                    <option value="Neft" @selected(old('paymentMode') == 'Neft')>NEFT</option>
                                </select>
                            </div>

                            {{-- Remarks --}}
                            <div class="col-md-12">
                                <label for="remarks" class="form-label">Booking Remarks</label>
                                {{-- Fixed textarea value population --}}
                                <textarea class="form-control" id="remarks" rows="2" name="remarks">{{ old('remarks') }}</textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary w-50">Create Booking</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- jQuery (Only one version) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @section('script')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize Select2
            $('.select2-enable').select2({
                width: '100%'
            });

            // 2. Auto Calculate Down Payment
            $('#total_amount, #adv_amount, #finance_amount').on('input', function() {
                var total = parseFloat($('#total_amount').val()) || 0;
                var advance = parseFloat($('#adv_amount').val()) || 0;
                var finance = parseFloat($('#finance_amount').val()) || 0;

                var dp = total - advance - finance;
                $('#dp').val(dp.toFixed(2));
            });

            // 3. Disable Submit Button on Form Submit
            $('form').on('submit', function() {
                var $btn = $(this).find('button[type="submit"]');
                
                // Change text to show processing and disable the button
                $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                $btn.prop('disabled', true);
            });
        });
    </script>
@endsection
@endsection