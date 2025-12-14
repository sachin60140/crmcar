@extends('admin.layouts.app')

@section('title', 'Add File | Car 4 Sale')

@section('style')
<style>
    /* Remove spin buttons from number inputs */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Blinking animation class */
    .blink-text {
        animation: blink 1s infinite;
        color: red;
        font-weight: bold;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.5; } /* Changed to 0.5 for smoother effect */
        100% { opacity: 1; }
    }
</style>
@endsection

@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">DTO</li>
            <li class="breadcrumb-item active">Add File</li>
        </ol>
    </nav>
</div><section class="section dashboard">
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
        <div class="card-header bg-light">
            <h5 class="card-title m-0">Add DTO File <span class="blink-text float-end" style="font-size: 0.8rem;">Note: Upload File Less than 10MB</span></h5>
        </div>
        <div class="card-body pt-3">
            
            <form class="row g-3" action="{{ url('admin/dto/store-dto-file') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                    <label for="reg_number" class="form-label">Registration Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control text-uppercase" id="reg_number" name="reg_number" 
                           value="{{ old('reg_number') }}" autofocus required placeholder="e.g. MH02AB1234">
                </div>
                <div class="col-md-6">
                    <label for="rto_location" class="form-label">RTO Location <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="rto_location" name="rto_location" 
                           value="{{ old('rto_location') }}" placeholder="Enter RTO Location" required>
                </div>

                <hr class="my-3 text-muted">

                <div class="col-md-3">
                    <label for="purchaser_name" class="form-label">Purchaser Name</label>
                    <input type="text" class="form-control" id="purchaser_name" name="purchaser_name" 
                           value="{{ old('purchaser_name') }}" placeholder="Enter Purchaser Name">
                </div>
                <div class="col-md-3">
                    <label for="Purchaser_mobile_number" class="form-label">Purchaser Mobile</label>
                    <input type="number" class="form-control" id="Purchaser_mobile_number" name="Purchaser_mobile_number" 
                           value="{{ old('Purchaser_mobile_number') }}" placeholder="10 Digit Mobile">
                </div>
                <div class="col-md-3">
                    <label for="vendor_name" class="form-label">Vendor Name</label>
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" 
                           value="{{ old('vendor_name') }}" placeholder="Enter Vendor Name">
                </div>
                <div class="col-md-3">
                    <label for="vendor_mobile_number" class="form-label">Vendor Mobile</label>
                    <input type="number" class="form-control" id="vendor_mobile_number" name="vendor_mobile_number" 
                           value="{{ old('vendor_mobile_number') }}" placeholder="10 Digit Mobile">
                </div>

                <hr class="my-3 text-muted">

                
                <div class="col-md-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select id="status" class="form-select" name="status" required>
                        <option value="">Choose...</option>
                        <option value="Ready to Dispatch" {{ old('status') == 'Ready to Dispatch' ? 'selected' : '' }}>Ready to Dispatch</option>
                        <option value="Dispatched" {{ old('status') == 'Dispatched' ? 'selected' : '' }}>Dispatched</option>
                        <option value="Online" {{ old('status') == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="Hold" {{ old('status') == 'Hold' ? 'selected' : '' }}>Hold</option>
                    </select>
                </div>
                <div class="col-md-3" id="dispatch_date_div">
                    <label for="dispatch_date" class="form-label">Dispatch Date</label>
                    <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" 
                        value="{{ old('dispatch_date') }}">
                </div>
                <div class="col-md-6">
                    <label for="upload_pdf" class="form-label">Upload PDF File <span class="text-danger">* (Max 10MB)</span></label>
                    <input type="file" class="form-control" id="upload_pdf" name="upload_pdf" accept="application/pdf" required>
                </div>
                
                <div class="col-12">
                    <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="remarks" name="remarks" 
                           value="{{ old('remarks') }}" required placeholder="Enter remarks here...">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">Submit</button>
                </div>
            </form>

        </div>
    </div>
</section>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    
    $(document).ready(function() {
        
        // Function to toggle visibility
        function toggleDispatchDate() {
            var status = $('#status').val();
            
            if (status === 'Ready to Dispatch') {
                $('#dispatch_date_div').hide(); // Hide the div
                $('#dispatch_date').val('');    // Optional: Clear the date value
            } else {
                $('#dispatch_date_div').show(); // Show the div
            }
        }

        // Run on Page Load (to handle 'old' values after validation error)
        toggleDispatchDate();

        // Run on Dropdown Change
        $('#status').change(function() {
            toggleDispatchDate();
        });

    });
</script>
@endsection