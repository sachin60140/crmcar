@extends('admin.layouts.app')

@section('title', 'Add Inspection Report | Car 4 Sale')


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
                <li class="breadcrumb-item active">Workshop</li>
                <li class="breadcrumb-item active">Add Inspection</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
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
            <div class="card-body text-center">
                <h5 class="card-title mb-3 ">Add Inspection</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{ route('storeinspection') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Registration Number<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" value="{{ old('reg_number') }}" name="reg_number" autofocus require>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Purchase Date<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" id="purchase_date"  value="{{ old('purchase_date') }}" name="purchase_date">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Vendor Name<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="vendor_name"  value="{{ old('vendor_name') }}" name="vendor_name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Vendor Mobile<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="vendor_mobile"  value="{{ old('vendor_mobile') }}" maxlength="10" name="vendor_mobile">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Upload  Images<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control"  name="pur_ins_image[]" multiple >
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Remarks<span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="remarks"  value="{{ old('remarks') }}" name="remarks" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        
                    </div>
                </form>

            </div>
        </div>



        </div>
    @endsection

    @section('script')
    @endsection
