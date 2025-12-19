@extends('admin.layouts.app')
@section('title', 'Add File | Car 4 Sale')

@section('style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .flatpickr-input[readonly] {
            background-color: #fff !important;
        }

        /* Keeps it white even if readonly */
        /* Preview Container */
        #pdf_preview_container {
            display: none;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
            background: #f9f9f9;
            height: 500px;
        }

        #pdf_viewer {
            width: 100%;
            height: 100%;
        }

        /* Progress Bar */
        .progress {
            height: 25px;
            display: none;
            /* Hidden by default */
            margin-top: 10px;
        }

        .progress-bar {
            font-weight: bold;
            line-height: 25px;
        }
    </style>
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Add DTO File</h1>
    </div>

    <section class="section dashboard">
        <div id="msg_container"></div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title m-0">Add File <span class="float-end text-muted small">Max: 10MB</span></h5>
            </div>
            <div class="card-body pt-3">

                <form id="dtoForm" action="{{ url('admin/dto/store-dto-file') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Reg Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" name="reg_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">RTO Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="rto_location" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Purchaser Name</label>
                            <input type="text" class="form-control" name="purchaser_name">
                        </div>
                        <div class="col-md-3">
                        <label class="form-label">Purchaser Mobile</label>
                        <input type="tel" class="form-control" name="Purchaser_mobile_number" id="Purchaser_mobile_number"
                             value="{{ old('Purchaser_mobile_number') }}"
                            maxlength="10">
                             <p id="msg"></p>
                    </div>

                        <div class="col-md-3">
                            <label class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" name="vendor_name">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Vendor Mobile</label>
                            <input type="text" class="form-control" name="vendor_mobile_number" maxlength="10">
                        </div>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Financer</label>
                            <select class="form-select" name="financer">
                                <option value="">Select Financer...</option>

                                @foreach ($financers as $item)
                                    {{-- Replace 'name' with your actual DB column name (e.g., financer_name) --}}
                                    <option value="{{ $item->financer_name }}">{{ $item->financer_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Challan Date</label>
                            <input type="text" class="form-control" id="challan_date" name="challan_date" readonly
                                placeholder="YYYY-MM-DD">
                        </div>
                    </div>
                    <hr class="my-3 text-muted">

                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" class="form-select" name="status" required>
                                <option value="">Choose...</option>
                                <option value="Ready to Dispatch">Ready to Dispatch</option>
                                <option value="Dispatched">Dispatched</option>
                                <option value="Online">Online</option>
                                <option value="Hold">Hold</option>
                            </select>
                        </div>

                        <div class="col-md-3" id="dispatch_date_div" style="display: none;">
                            <label class="form-label">Dispatch Date <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dispatch_date" name="dispatch_date" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Upload PDF <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="upload_pdf" name="upload_pdf"
                                accept="application/pdf" required>
                        </div>
                    </div>

                    <div id="pdf_preview_container">
                        <h6 class="text-muted border-bottom pb-2">PDF Preview</h6>
                        <embed id="pdf_viewer" style="width:100%; height:450px; border:1px solid #ccc;" src=""
                            type="application/pdf">
                    </div>

                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                            style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Remarks <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="remarks" required
                                placeholder="Enter remarks (This will be saved to history)">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" id="submitBtn" class="btn btn-primary px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            // Apply to Challan and Dispatch dates
            flatpickr("#challan_date, #dispatch_date", {
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "F j, Y", // Shows "December 19, 2025" but sends "2025-12-19"
                maxDate: "today", // Disables all dates greater than today
                locale: {
                    firstDayOfWeek: 1 // Optional: Starts week on Monday
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // --- 1. Reg Number Prefix Auto-fill (Triggered at 4 Characters) ---
            $('input[name="reg_number"]').on('input', function() {
                // Remove spaces/hyphens and convert to uppercase for consistency
                var regNo = $(this).val().replace(/[\s-]/g, '').toUpperCase();
                var $rtoLocationField = $('input[name="rto_location"]');

                // Trigger lookup only when exactly 4 characters are reached
                if (regNo.length === 4) {
                    $.ajax({
                        url: "{{ url('admin/dto/get-dto-location') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            reg_number: regNo
                        },
                        success: function(response) {
                            if (response.location) {
                                $rtoLocationField.val(response.location);
                            }
                        },
                        error: function() {
                            // Optional: Clear field if no match is found
                            $rtoLocationField.val('');
                        }
                    });
                } else if (regNo.length < 4) {
                    // Clear the location if the user deletes characters
                    $rtoLocationField.val('');
                }
            });

            // --- 2. PDF Preview Logic ---
            $('#upload_pdf').change(function(e) {
                var file = e.target.files[0];
                if (file && file.type === "application/pdf") {
                    var fileURL = URL.createObjectURL(file);
                    $('#pdf_viewer').attr('src', fileURL);
                    $('#pdf_preview_container').slideDown();
                } else {
                    $('#pdf_preview_container').slideUp();
                    alert("Please select a valid PDF file.");
                    $(this).val('');
                }
            });

            // --- 3. Datepicker & UI Logic ---
            $("#dispatch_date").datepicker({
                dateFormat: "yy-mm-dd"
            });

            $("#challan_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });

            function toggleDate() {
                var status = $('#status').val();
                if (status === 'Ready to Dispatch' || status === 'Hold' || status === '') {
                    $('#dispatch_date_div').hide();
                    $('#dispatch_date').prop('required', false).val('');
                } else {
                    $('#dispatch_date_div').show();
                    $('#dispatch_date').prop('required', true);
                }
            }
            $('#status').change(toggleDate);
            toggleDate();

            // --- 4. AJAX Submit with Progress Bar ---
            $('#dtoForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var $btn = $('#submitBtn');
                var $progressDiv = $('.progress');
                var $progressBar = $('.progress-bar');
                var $msg = $('#msg_container');

                $msg.html('');
                $btn.prop('disabled', true).text('Uploading...');
                $progressDiv.show();
                $progressBar.width('0%').text('0%');

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt
                                    .total) * 100);
                                $progressBar.width(percentComplete + '%').text(
                                    percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $progressBar.removeClass('bg-success').addClass('bg-primary').text(
                            'Completed');
                        $msg.html(`<div class="alert alert-success">${response.message}</div>`);
                        $('#dtoForm')[0].reset();
                        $('#pdf_preview_container').hide();
                        toggleDate();
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");

                        setTimeout(() => {
                            $progressDiv.slideUp();
                        }, 2000);
                    },
                    error: function(xhr) {
                        $progressDiv.hide();
                        var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                        var errorHtml = '<ul>';
                        if (errors) {
                            $.each(errors, function(key, val) {
                                errorHtml += `<li>${val[0]}</li>`;
                            });
                        } else {
                            errorHtml += `<li>${xhr.statusText || 'Server Error'}</li>`;
                        }
                        errorHtml += '</ul>';
                        $msg.html(`<div class="alert alert-danger">${errorHtml}</div>`);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>
    <script>
        const mobile = document.getElementById('Purchaser_mobile_number');
        const msg = document.getElementById('msg');
        
        mobile.addEventListener('input', function() {
            const num = this.value;
            
            // Validation logic
            if (!/^\d*$/.test(num)) {
                msg.textContent = "Only digits allowed";
                msg.style.color = "red";
                return;
            }
            
            if (num.length !== 10) {
                msg.textContent = "Must be 10 digits";
                msg.style.color = "red";
                return;
            }
            
            if (!/^[6-9]/.test(num)) {
                msg.textContent = "Must start with 6-9";
                msg.style.color = "red";
                return;
            }
            
            msg.textContent = "✓ Valid mobile number";
            msg.style.color = "green";
        });
    </script>
@endsection
