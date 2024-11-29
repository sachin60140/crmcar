@extends('admin.layouts.app')

@section('title', 'Add File | Car 4 Sale')


@section('style')

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @keyframes blink {

            0% { opacity: 1; }

            50% { opacity: 0; }

            100% { opacity: 1; }

            }

    </style>

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">DTO</li>
                <li class="breadcrumb-item active">Add File</li>
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
            <div class="card-body">
                <h5 class="card-title">Add DTO File <span style="animation: blink 1s infinite; color: red;">Please Upload File Less then 10MB</span></h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{url('admin/dto/store-dto-file')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <label for="reg_number" class="form-label">Registration Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('reg_number') }}"
                            name="reg_number" autofocus required>
                    </div>
                    <div class="col-md-4">
                        <label for="rto_location" class="form-label">RTO Location <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('rto_location') }}"
                            name="rto_location" placeholder="Enter Rto Location" required>
                    </div>
                    <div class="col-md-4">
                        <label for="vendor_name" class="form-label">Vendor Name </label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('vendor_name') }}"
                            name="vendor_name" placeholder="Enter Vendor Name">
                    </div>
                    <div class="col-md-4">
                        <label for="vendor_mobile_number" class="form-label">Vendor Mobile </label>
                        <input type="Text" class="form-control" id="inputName5" value="{{ old('vendor_mobile_number') }}"
                            name="vendor_mobile_number" >
                    </div>
                    <div class="col-md-4">
                        <label for="dispatch_date" class="form-label">Dispatch Date </label>
                        <input type="date" class="form-control" id="inputName5" value="{{ old('dispatch_date') }}"
                            name="dispatch_date" >
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status <span style="color: red;">*</span></label>
                        <select id="status" class="form-select" name="status">
                            <option value="" selected>Choose...</option>
                            <option value="Ready to Dispatch">Ready to Dispatch</option>
                            <option value="Dispatched">Dispatched</option>
                            <option value="Online">Online</option>
                            <option value="Hold">Hold</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="upload_pdf" class="form-label">Upload PDF File <span style="color: red;">Less then 10MB *</span></label>
                        <input type="file" class="form-control" id="inputName5" value="{{ old('upload_pdf') }}"
                            name="upload_pdf" required>
                    </div>
                   
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Remarks <span style="color: red;">* </span></label>
                        <input type="text" class="form-control" id="remarks" name="remarks"
                            value="{{ old('remarks') }}" required>
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
