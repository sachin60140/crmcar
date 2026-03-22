@extends('admin.layouts.app')

@section('title', 'Car Booking | Car 4 Sale')

@section('style')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    
    <style>
        /* Hide HTML5 arrows for number inputs */
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
        
        /* Select2 Bootstrap 5 Fixes */
        .select2-container .select2-selection--single { height: 38px !important; padding: 5px !important; border: 1px solid #dee2e6 !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px !important; }
        
        /* Smooth transition for TXN field */
        #txn_div { display: none; }
        .is-invalid-custom { border: 2px solid #dc3545 !important; color: #dc3545 !important; }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Add New Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Booking</li>
                <li class="breadcrumb-item active">Add Booking</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-9 mx-auto">
                
                {{-- Alert Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form class="row g-3" action="{{ route('storebooking') }}" method="POST" id="bookingForm">
                            @csrf
                            
                            {{-- Vehicle Selection --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Select Vehicle</label>
                                <select class="form-select select2-enable" name="reg_number" required>
                                    <option value="">Choose Vehicle...</option>
                                    @foreach ($car_stock as $item)
                                        <option value="{{ $item->id }}" @selected(old('reg_number') == $item->id)>
                                            {{ $item->reg_number }} — {{ $item->car_model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Booking Person (Sales Person) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sales Person</label>
                                <select class="form-select select2-enable" name="booking_person" required>
                                    <option value="">Select Sales Person...</option>
                                    @foreach ($sales_person as $item)
                                        <option value="{{ $item->name }}" @selected(old('booking_person') == $item->name)>
                                            {{ $item->name }} ({{ $item->branch }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Customer Selection --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Customer</label>
                                <select class="form-select select2-enable" name="customer" required>
                                    <option value="">Choose Customer...</option>
                                    @foreach ($ledger as $item)
                                        <option value="{{ $item->id }}" @selected(old('customer') == $item->id)>
                                            {{ $item->name }} — {{ $item->mobile_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-12"><hr class="my-3"></div>

                            {{-- Amount Fields --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sell Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">₹</span>
                                    <input type="number" step="any" class="form-control calc-trigger" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Advance Paid</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">₹</span>
                                    <input type="number" step="any" class="form-control calc-trigger" id="adv_amount" name="adv_amount" value="{{ old('adv_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Finance Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">₹</span>
                                    <input type="number" step="any" class="form-control calc-trigger" id="finance_amount" name="finance_amount" value="{{ old('finance_amount') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Pending Down Payment (Auto)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white" id="dp_icon">₹</span>
                                    <input type="number" step="any" class="form-control bg-light fw-bold" id="dp" name="dp" value="{{ old('dp') }}" readonly>
                                </div>
                            </div>
                            
                            {{-- Payment Mode & TXN ID --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Payment Mode</label>
                                <select class="form-select" name="paymentMode" id="paymentMode" required>
                                    <option value="">Select Mode...</option>
                                    <option value="Cash" @selected(old('paymentMode') == 'Cash')>Cash</option>
                                    <option value="UPI" @selected(old('paymentMode') == 'UPI')>UPI</option>
                                    <option value="NEFT" @selected(old('paymentMode') == 'NEFT')>NEFT</option>
                                    <option value="RTGS" @selected(old('paymentMode') == 'RTGS')>RTGS</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="txn_div">
                                <label class="form-label fw-bold">TXN ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txn_id" name="txn_id" value="{{ old('txn_id') }}" placeholder="Enter Transaction ID">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="2" placeholder="Enter any additional details...">{{ old('remarks') }}</textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" id="submitBtn">
                                    Confirm Booking
                                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize Select2
            $('.select2-enable').select2({ width: '100%' });

            // 2. TXN ID Logic: Show if not Cash, hide if Cash
            function toggleTxnField() {
                let mode = $('#paymentMode').val();
                if (mode !== "" && mode !== "Cash") {
                    $('#txn_div').fadeIn();
                    $('#txn_id').prop('required', true);
                } else {
                    $('#txn_div').fadeOut();
                    $('#txn_id').prop('required', false).val('');
                }
            }
            $('#paymentMode').on('change', toggleTxnField);
            toggleTxnField(); // Run on page load

            // 3. Auto Calculation & Real-time Balance Check
            $('.calc-trigger').on('input', function() {
                let total = parseFloat($('#total_amount').val()) || 0;
                let advance = parseFloat($('#adv_amount').val()) || 0;
                let finance = parseFloat($('#finance_amount').val()) || 0;
                
                let dp = total - advance - finance;
                $('#dp').val(dp.toFixed(2));

                // Validation: Prevent Advance + Finance > Total Sell Amount
                if (dp < 0) {
                    $('#dp').addClass('is-invalid-custom');
                    $('#dp_icon').removeClass('bg-primary').addClass('bg-danger');
                    $('#submitBtn').prop('disabled', true).text('Invalid Amount Balance');
                } else {
                    $('#dp').removeClass('is-invalid-custom');
                    $('#dp_icon').removeClass('bg-danger').addClass('bg-primary');
                    $('#submitBtn').prop('disabled', false).text('Confirm Booking');
                }
            });

            // 4. Form Submission Handling
            $('#bookingForm').on('submit', function(e) {
                let $btn = $('#submitBtn');
                $btn.html('<span class="spinner-border spinner-border-sm"></span> Processing...');
                $btn.prop('disabled', true);
            });

            // 5. Global Success Toast (for session flash)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endsection