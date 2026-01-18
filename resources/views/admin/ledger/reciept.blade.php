@extends('admin.layouts.app')

@section('title', 'Payment Receipt | Car 4 Sale')

@section('style')
    <style>
        /* Modern Card Styling */
        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #fff;
            overflow: hidden;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            padding: 20px;
            color: white;
            text-align: center;
        }

        /* Input Styling */
        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        }

        /* Remove number spinner */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Balance Info Box */
        .balance-box {
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 10px 15px;
            border-radius: 4px;
            display: none; /* Hidden by default until client selected */
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control, .form-select {
            border-left: none;
        }
        /* Fix for floating labels with input groups */
        .input-group > .form-floating {
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
        }
        .input-group .input-group-text {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border: 1px solid #ced4da;
            border-right: 0;
        }
        .input-group .form-control, .input-group .form-select {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 0; 
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle mb-4">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">New Payment Receipt</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <strong>Please check the form:</strong>
                        <ul class="mb-0 mt-1 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card card-modern">
                    <div class="card-header-modern">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Payment Entry</h4>
                        <small class="opacity-75">Record a new payment transaction</small>
                    </div>

                    <div class="card-body p-4">
                        <form class="row g-4" action="{{ route('storerecieptpayment') }}" method="POST">
                            @csrf
                            
                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <div class="form-floating">
                                        <select class="form-select" name="client_name" id="client_name" required autofocus>
                                            <option value="" selected disabled>Select Client...</option>
                                            @foreach ($clientlist as $clients)
                                                <option {{ old('client_name') == $clients->id ? 'selected' : '' }} value="{{ $clients->id }}">
                                                    {{ $clients->name }} ({{ $clients->mobile_number }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="client_name">Client Ledger</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div id="balance_container" class="balance-box d-flex justify-content-between align-items-center">
                                    <span class="text-muted small text-uppercase fw-bold">Current Outstanding</span>
                                    <span id="dues" class="fw-bold fs-5 text-danger">--</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <div class="form-floating">
                                        <select class="form-select" name="paymentMode" id="paymentMode" required>
                                            <option value="" selected disabled>Mode...</option>
                                            <option value="Cash" {{ old('paymentMode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="UPI" {{ old('paymentMode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                                            <option value="NEFT" {{ old('paymentMode') == 'NEFT' ? 'selected' : '' }}>NEFT</option>
                                            <option value="RTGS" {{ old('paymentMode') == 'RTGS' ? 'selected' : '' }}>RTGS</option>
                                        </select>
                                        <label for="paymentMode">Payment Mode</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="txn_date" id="txn_date" value="{{ old('txn_date') }}" required>
                                        <label for="txn_date">Txn Date</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <div class="form-floating">
                                        <input type="number" min="0.00" max="1500000.00" step="1" class="form-control fw-bold fs-5 text-success" name="amount" id="amount" placeholder="0.00" value="{{ old('amount') }}" required>
                                        <label for="amount">Received Amount</label>
                                    </div>
                                </div>
                                <div class="form-text text-end">Max limit: ₹15,00,000.00</div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="remarks" name="remarks" style="height: 100px">{{ old('remarks') }}</textarea>
                                    <label for="remarks">Remarks / Notes</label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm rounded-pill">
                                    <i class="bi bi-check2-circle me-2"></i> Save Payment
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Client Selection Change
            $('#client_name').on('change', function() {
                var customerid = $(this).val();

                if (customerid) {
                    $('#balance_container').slideDown(); // Show the box nicely
                    $('#dues').html('<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>');
                    
                    $.ajax({
                        url: '/admin/customer/getcustomerbalance',
                        type: 'post',
                        data: {
                            customerid: customerid,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            // Assuming result is formatted like "₹ 50,000.00" or just numbers
                            $('#dues').html(result).addClass('text-danger');
                        },
                        error: function() {
                            $('#dues').text('Error fetching balance');
                        }
                    });
                } else {
                    $('#balance_container').slideUp();
                    $('#dues').html('');
                }
            });
        });
    </script>
@endsection