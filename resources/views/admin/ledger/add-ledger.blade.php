@extends('admin.layouts.app')

@section('title', 'Add Ledger | Car 4 Sale')

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
                <li class="breadcrumb-item active">Customer</li>
                <li class="breadcrumb-item active">Add Ledger</li>
            </ol>
        </nav>
    </div>
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
                <h5 class="card-title">Add Ledger</h5>

                <form class="row g-3" action="{{ route('storeledger') }}" method="POST">
                    @csrf

                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Mobile <span style="color: red;">*</span></label>
                        <input type="tel" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}"
                            name="mobile_number" pattern="[0-9]{10}" maxlength="10" required autocomplete="off">
                        <small class="text-muted" id="loading-msg" style="display:none;">Searching...</small>
                    </div>

                    <div class="col-md-4">
                        <label for="fee" class="form-label">Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                            name="name">
                    </div>

                    <div class="col-md-4">
                        <label for="fee" class="form-label">Father's Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="f_name" value="{{ old('f_name') }}"
                            name="f_name">
                    </div>

                    <div class="col-md-4">
                        <label for="fee" class="form-label">Aadhar <span style="color: red;">*</span></label>
                        <input type="text" class="form-control check-duplicate" id="aadhar" maxlength="12" value="{{ old('aadhar') }}"
                            name="aadhar" autocomplete="off">
                        <span class="error-msg text-danger small"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="fee" class="form-label">Pan Card <span style="color: red;">*</span></label>
                        <input type="text" class="form-control check-duplicate" id="pan_card" maxlength="10"
                            value="{{ old('pan_card') }}" name="pan_card" autocomplete="off">
                        <span class="error-msg text-danger small"></span>
                    </div>

                    <div class="col-4">
                        <label for="inputAddress2" class="form-label">City <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City"
                            value="{{ old('city') }}" required>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Address<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Apartment, studio, or floor" value="{{ old('address') }}" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary ms-2" id="reset_btn">Reset Form</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        // --- Configuration & Selectors ---
        var $autoFillFields = $('#name, #f_name, #aadhar, #pan_card, #city, #address');
        var $mobileInput = $('#mobile_number');
        var $submitBtn = $('button[type="submit"]');
        var $resetBtn = $('#reset_btn');
        var $loadingMsg = $('#loading-msg');

        // --- 1. Auto-Fill Logic (Mobile Number) ---
        $mobileInput.on('keyup blur', function() {
            var mobile = $(this).val();

            if (mobile.length === 10) {
                $loadingMsg.show();

                $.ajax({
                    url: "{{ route('get.ledger.details') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mobile_number: mobile
                    },
                    success: function(response) {
                        $loadingMsg.hide();

                        if (response.found) {
                            // Fill Data
                            $('#name').val(response.data.name); // Ensure case matches your DB column (Name vs name)
                            $('#f_name').val(response.data.f_name);
                            $('#aadhar').val(response.data.aadhar);
                            $('#pan_card').val(response.data.pan);
                            $('#city').val(response.data.city);
                            $('#address').val(response.data.address);

                            // Lock fields
                            $autoFillFields.prop('readonly', true);
                            
                            // Visuals
                            $mobileInput.addClass('is-valid').removeClass('is-invalid');
                            $autoFillFields.addClass('is-valid').removeClass('is-invalid');
                            
                            // Clear errors
                            $('.error-msg').text('');
                            $submitBtn.prop('disabled', false);

                        } else {
                            // Unlock fields
                            $autoFillFields.prop('readonly', false);
                            $autoFillFields.removeClass('is-valid is-invalid');
                            $mobileInput.addClass('is-valid');
                        }
                    },
                    error: function() {
                        $loadingMsg.hide();
                    }
                });
            } 
            else if (mobile.length < 10) {
                $autoFillFields.val('').prop('readonly', false).removeClass('is-valid is-invalid');
                $mobileInput.removeClass('is-valid is-invalid');
            }
        });


        // --- 2. Duplicate Check Logic (Aadhar & PAN) ---
        // Requires class="check-duplicate" on inputs and <span class="error-msg"></span> after inputs
        $('.check-duplicate').on('blur', function() {
            var $input = $(this);
            var fieldName = $input.attr('name'); 
            var value = $input.val();
            var $errorSpan = $input.next('.error-msg');

            // Skip if empty or readonly
            if (value === '' || $input.prop('readonly')) {
                $errorSpan.text('');
                $input.removeClass('is-invalid');
                return;
            }

            $.ajax({
                url: "{{ route('check.duplicate') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    field_name: fieldName,
                    value: value
                },
                success: function(response) {
                    if (response.exists) {
                        $errorSpan.text('This ' + fieldName + ' is already registered.');
                        $input.addClass('is-invalid').removeClass('is-valid');
                        $submitBtn.prop('disabled', true);
                    } else {
                        $errorSpan.text('');
                        $input.removeClass('is-invalid').addClass('is-valid');

                        if ($('.is-invalid').length === 0) {
                            $submitBtn.prop('disabled', false);
                        }
                    }
                },
                error: function() {
                    console.error("Error checking duplicate");
                }
            });
        });


        // --- 3. Reset Button Logic ---
        $resetBtn.click(function() {
            $('form')[0].reset();
            $autoFillFields.prop('readonly', false);
            $('.form-control').removeClass('is-valid is-invalid');
            $('.error-msg').text('');
            $submitBtn.prop('disabled', false);
            $mobileInput.focus();
        });

    });
</script>
@endsection