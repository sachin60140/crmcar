@extends('employee.layouts.app')

@section('title', 'Add Visitor | Car 4 Sales')

@section('style')
    <style>
        /* 1. Hide default number arrows */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* 2. Validation Icon Styling */
        .input-group-text {
            background-color: transparent;
            border-left: 0;
        }

        /* Color the icon based on validation state */
        .is-valid+.input-group-text {
            border-color: #198754;
        }

        .is-invalid+.input-group-text {
            border-color: #dc3545;
        }
    </style>
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Visitor Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employee/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Visitor</li>
                <li class="breadcrumb-item active">Add Visitor</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-6 mx-auto">

                <div id="response_message"></div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Add New Visitor</h5>

                        <form id="visitorForm" class="row g-3">
                            @csrf

                            <div class="col-md-12">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter visitor name" required autofocus>
                            </div>

                            <div class="col-md-12">
                                <label for="mobile_number" class="form-label">Mobile <span
                                        class="text-danger">*</span></label>

                                <div class="input-group has-validation">
                                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                        maxlength="10" placeholder="9999999999"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>

                                    <span class="input-group-text" id="status-icon" style="display:none;"></span>

                                    <div id="mobile_feedback" class="invalid-feedback">
                                        Please enter valid 10 digit number.
                                    </div>
                                </div>
                                <small class="text-muted" style="font-size: 12px;">Enter 10 digit mobile number
                                    only.</small>
                            </div>

                            <div class="col-md-12">
                                <label for="car_require" class="form-label">Car Requirement <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="car_require" name="car_require"
                                    placeholder="e.g. Swift, Alto, SUV" required>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Village/City/Area" required>
                            </div>

                            <div class="col-md-12">
                                <label for="refrence" class="form-label">Reference <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="refrence" name="refrence"
                                    placeholder="How did they find us?" required>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                    Submit Visitor
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
        $(document).ready(function() {

            // --- 1. Real-time Mobile Validation ---
            $('#mobile_number').on('input', function() {
                var mobile = $(this).val();
                var inputField = $(this);
                var statusIcon = $('#status-icon');
                var feedback = $('#mobile_feedback');

                if (mobile.length === 0) {
                    inputField.removeClass('is-valid is-invalid');
                    statusIcon.hide();
                } 
                else if (mobile.length === 10) {
                    inputField.removeClass('is-invalid').addClass('is-valid');
                    statusIcon.html('<i class="bi bi-check-circle-fill text-success"></i>').show();
                } 
                else {
                    inputField.removeClass('is-valid').addClass('is-invalid');
                    feedback.text("Must be exactly 10 digits. Current: " + mobile.length);
                    statusIcon.html('<i class="bi bi-exclamation-circle-fill text-danger"></i>').show();
                }
            });

            // --- 2. AJAX Form Submission ---
            $('#visitorForm').on('submit', function(e) {
                e.preventDefault(); // Stop page reload

                // Front-end Mobile Check
                var mob = $('#mobile_number').val();
                if(mob.length != 10) {
                    $('#mobile_number').focus();
                    return false;
                }

                var submitBtn = $('#submitBtn');
                var originalBtnText = submitBtn.text();

                // Disable Button & Show Spinner
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');
                $('#response_message').html(''); // Clear previous alerts
                
                // FIX: Remove old "Red" error borders before sending new request
                $('.form-control').removeClass('is-invalid'); 

                $.ajax({
                    type: "POST",
                    url: "{{ route('addvisitor') }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        
                        if(response.status == 200) {
                            // --- SUCCESS ---
                            $('#response_message').html(
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' + 
                                '<i class="bi bi-check-circle-fill me-2"></i>' + 
                                response.message + 
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>'
                            );
                            
                            // Auto-Close Success Message after 3 seconds
                            setTimeout(function() {
                                $("#response_message .alert").fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove(); 
                                });
                            }, 3000); 

                            // Reset Form & Visuals
                            $('#visitorForm')[0].reset(); 
                            $('.form-control').removeClass('is-valid is-invalid');
                            $('#status-icon').hide();
                            $('#name').focus();
                        } 
                        else if(response.status == 400) {
                            // --- VALIDATION ERROR ---
                            var errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Please fix the following:</strong><ul>';
                            $.each(response.errors, function(key, err_values) {
                                errorHtml += '<li>' + err_values + '</li>';
                                $('#'+key).addClass('is-invalid'); // Turn field red
                            });
                            errorHtml += '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            
                            $('#response_message').html(errorHtml);
                        }
                        else {
                            // --- SERVER ERROR ---
                            $('#response_message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        $('#response_message').html('<div class="alert alert-danger">System Error. Please check internet connection.</div>');
                    },
                    complete: function() {
                        // Re-enable Button
                        submitBtn.prop('disabled', false).text(originalBtnText);
                        $('html, body').animate({ scrollTop: 0 }, 'fast');
                    }
                });
            });
        });
    </script>
@endsection
