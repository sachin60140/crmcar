@extends('admin.layouts.app')

@section('title', 'Add Vendor | Car 4 Sale')


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
                <li class="breadcrumb-item active">Vendor</li>
                <li class="breadcrumb-item active">Add Vendor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
       <div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h4 class="mb-0 text-primary">Vendor List</h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addVendorModal">
            <i class="bi bi-plus-lg"></i> Add New Vendor
        </button>
    </div>
    <div class="card-body">
        
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
            </div>
        @endif
    
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="vendorTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Father's Name</th>
                        <th>Aadhar</th>
                        <th>City</th>
                        <th>Address</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->mobile }}</td>
                        <td>{{ $vendor->father_name }}</td>
                        <td>{{ $vendor->aadhar_number }}</td>
                        <td>{{ $vendor->city }}</td>
                        <td>{{ $vendor->address }}</td>
                       
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addVendorModal" tabindex="-1" aria-labelledby="addVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addVendorModalLabel">Add New Vendor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('storevendor') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Mobile <span class="text-danger">*</span></label>
                            <input type="number" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ old('father_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Aadhar Number <span class="text-danger">*</span></label>
                            <input type="text" name="aadhar_number" class="form-control" value="{{ old('aadhar_number') }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="2" name="address" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Pincode <span class="text-danger">*</span></label>
                            <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>
        
    @endsection

    @section('script')
    <script>
    $(document).ready(function () {
        // Initialize DataTables
        $('#vendorTable').DataTable({
            "order": [[ 0, "desc" ]]
        });

        // Check if there are validation errors. 
        // If yes, trigger the modal to open immediately so user sees the errors.
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('addVendorModal'), {
                keyboard: false
            });
            myModal.show();
        @endif
    });
</script>
    @endsection
