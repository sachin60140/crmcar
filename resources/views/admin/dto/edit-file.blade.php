@extends('admin.layouts.app')

@section('title', 'Update DTO File | Car 4 Sale')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Remove spin buttons */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .bg-readonly {
            background-color: #e9ecef !important;
            cursor: not-allowed;
        }

        /* Style the datepicker input to look clickable */
        .date-picker {
            background-color: #fff !important;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Update DTO File</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">

        @if ($errors->any())
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body pt-3">
                <h5 class="card-title">Update DTO File</h5>

                <form class="row g-3" action="{{ url('admin/dto/update-dto-file/' . $getRecord->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. Registration Number (KEPT READONLY) --}}
                    <div class="col-md-4">
                        <label class="form-label">Registration Number</label>
                        <input type="text" class="form-control bg-readonly" value="{{ $getRecord->reg_number }}"
                            readonly>
                    </div>

                    {{-- 2. RTO Location (NOW EDITABLE) --}}
                    <div class="col-md-4">
                        <label class="form-label">RTO Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="rto_location"
                            value="{{ old('rto_location', $reglocation ?? $getRecord->rto_location) }}" required>
                        <small class="text-muted">Detected based on Reg. Number prefix</small>
                    </div>

                    {{-- 3. Uploaded By (Kept Readonly as it is System Data) --}}
                    <div class="col-md-4">
                        <label class="form-label">Uploaded By</label>
                        <input type="text" class="form-control bg-readonly" value="{{ $getRecord->created_by }}"
                            readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Purchaser Name</label>
                        <input type="text" class="form-control" id="purchaser_name" name="purchaser_name"
                            value="{{ old('purchaser_name', $getRecord->purchaser_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purchaser Mobile</label>
                        <input type="tel" class="form-control" name="Purchaser_mobile_number"
                            id="Purchaser_mobile_number" maxlength="10"
                            value="{{ old('Purchaser_mobile_number', $getRecord->Purchaser_mobile_number) }}">
                        <p id="msg"></p>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="vendor_name"
                            value="{{ old('vendor_name', $getRecord->vendor_name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Vendor Mobile <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="vendor_mobile_number"
                            value="{{ old('vendor_mobile_number', $getRecord->vendor_mobile_number) }}" maxlength="10"
                            required>
                    </div>

                    {{-- New Fields: Financer & Challan Date --}}
                    <div class="col-md-4">
                        <label class="form-label">Financer</label>
                        <select class="form-select" name="financer">
                            <option value="">Select Financer...</option>
                            @if (isset($financers))
                                @foreach ($financers as $item)
                                    <option value="{{ $item->financer_name }}"
                                        {{ isset($getRecord->financer) && $getRecord->financer == $item->financer_name ? 'selected' : '' }}>
                                        {{ $item->financer_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Challan Date</label>
                        <input type="text" class="form-control date-picker" name="challan_date"
                            value="{{ $getRecord->challan_date ? date('Y-m-d', strtotime($getRecord->challan_date)) : '' }}"
                            placeholder="Select Date">
                    </div>


                    <div class="col-md-4">
                        <label class="form-label">File Status <span class="text-danger">*</span></label>
                        <select id="status" class="form-select" name="status" required>
                            <option value="Ready to Dispatch"
                                {{ $getRecord->status == 'Ready to Dispatch' ? 'selected' : '' }}>Ready to Dispatch
                            </option>
                            <option value="Dispatched" {{ $getRecord->status == 'Dispatched' ? 'selected' : '' }}>
                                Dispatched</option>
                            <option value="Online" {{ $getRecord->status == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Hold" {{ $getRecord->status == 'Hold' ? 'selected' : '' }}>Hold</option>
                        </select>
                    </div>

                    {{-- REMOVED 'required' from HTML here. It is handled by JS toggleOnline() --}}
                    <div class="col-md-4" id="dispatch_date_div">
                        <label class="form-label">Dispatch Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control date-picker" id="dispatch_date" name="dispatch_date"
                            value="{{ $getRecord->dispatch_date ? date('Y-m-d', strtotime($getRecord->dispatch_date)) : '' }}"
                            placeholder="Select Date">
                    </div>


                    <div class="col-md-4 online-field" style="display: none;">
                        <label class="form-label">Online Date <span class="text-danger">*</span></label>
                        <input type="text" class="form-control date-picker" id="online_date" name="online_date"
                            value="{{ $getRecord->online_date ? date('Y-m-d', strtotime($getRecord->online_date)) : '' }}"
                            placeholder="Select Date">
                    </div>

                    <div class="col-md-4 online-field" style="display: none;">
                        <label class="form-label">Upload M-Parivahan</label>
                        <input type="file" class="form-control" name="upload_mparivahan">
                        @if ($getRecord->upload_mparivahan)
                            <small><a href="{{ asset('files/' . $getRecord->upload_mparivahan) }}" target="_blank">View
                                    Current M-Parivahan</a></small>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Update Main PDF File <small>(Optional)</small></label>
                        <input type="file" class="form-control" name="upload_pdf" accept="application/pdf">
                        @if ($getRecord->upload_pdf)
                            <small class="text-success"><a href="{{ asset('files/' . $getRecord->upload_pdf) }}"
                                    target="_blank">View Current PDF</a></small>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="form-label">Remarks <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="remarks"
                            value="{{ old('remarks', $getRecord->remarks) }}" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {

            // 1. Initialize Flatpickr (FIXED: altInput set to false)
            $(".date-picker").flatpickr({
                dateFormat: "Y-m-d", // Database format
                allowInput: true, // Allow manual typing if needed
                altInput: false, // <--- DISABLED to fix "invalid form control" error
                // altFormat: "F j, Y", // <--- Commented out as altInput is false
                maxDate: "today",
                locale: {
                    firstDayOfWeek: 1
                }
            });

            // 2. Logic to Show/Hide Online Fields
            function toggleOnline() {
                var status = $('#status').val();

                // Handle Online Fields
                if (status === 'Online') {
                    $('.online-field').show();
                    $('#online_date').prop('required', true);
                } else {
                    $('.online-field').hide();
                    $('#online_date').prop('required', false);
                }

                // Handle Dispatch Date Visibility (Hide on 'Hold' or 'Ready to Dispatch')
                // Adjust logic: If 'Ready to Dispatch' OR 'Hold', we usually HIDE the date? 
                // Based on your original code, it was hidden for 'Ready to Dispatch'.
                if (status === 'Ready to Dispatch' || status === 'Hold' || status === '') {
                    $('#dispatch_date_div').hide();
                    $('#dispatch_date').prop('required', false);
                } else {
                    $('#dispatch_date_div').show();
                    // We make it required when it is visible
                    $('#dispatch_date').prop('required', true);
                }
            }

            // Run on load and on change
            toggleOnline();
            $('#status').change(toggleOnline);

            // 3. Auto Capitalize Name
            $('#purchaser_name').on('input', function() {
                $(this).val($(this).val().toLowerCase().replace(/\b\w/g, c => c.toUpperCase()));
            });
        });
    </script>
    <script>
        const mobile = document.getElementById('Purchaser_mobile_number');
        const msg = document.getElementById('msg');

        if (mobile) { // Add check to prevent errors if element doesn't exist
            mobile.addEventListener('input', function() {
                const num = this.value;

                // Validation logic
                if (!/^\d*$/.test(num)) {
                    msg.textContent = "Only digits allowed";
                    msg.style.color = "red";
                    return;
                }

                if (num.length > 0 && num.length !== 10) {
                    msg.textContent = "Must be 10 digits";
                    msg.style.color = "red";
                    return;
                }

                if (num.length === 10 && !/^[6-9]/.test(num)) {
                    msg.textContent = "Must start with 6-9";
                    msg.style.color = "red";
                    return;
                }

                if (num.length === 10) {
                    msg.textContent = "✓ Valid mobile number";
                    msg.style.color = "green";
                } else {
                    msg.textContent = "";
                }
            });
        }
    </script>
@endsection