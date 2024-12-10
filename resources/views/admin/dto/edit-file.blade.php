@extends('admin.layouts.app')

@section('title', 'Update DTO File | Car 4 Sale')


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
                <li class="breadcrumb-item active">Update DTO File Status</li>
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
                <h5 class="card-title">Update DTO File</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="{{url('admin/dto/update-dto-file/'.$getRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-md-4">
                        <label for="fee" class="form-label">Registration Number <span style="color: red;">*</span></label>
                        <input type="text" readonly class="form-control" id="reg_number" value="{{$getRecord->reg_number}}"
                            name="reg_number"> 
                    </div>

                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">RTO Location <span
                                style="color: red;">*</span></label>
                        <input type="Text" readonly class="form-control" id="rto_location" value="{{$getRecord->rto_location}}"
                            name="rto_location" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Vendor Name <span
                                style="color: red;">*</span></label>
                        <input type="Text" autofocus class="form-control" id="vendor_name" value="{{$getRecord->vendor_name}}"
                            name="vendor_name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Vendor Mobile Number <span
                                style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="vendor_mobile_number" value="{{$getRecord->vendor_mobile_number}}"
                            name="vendor_mobile_number"  maxlength="10" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Dispatch Date <span style="color: red;">*</span></label>
                        <input type="date" class="form-control" id="dispatch_date" value="{{$getRecord->dispatch_date}}"
                            name="dispatch_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">File Status <span style="color: red;">*</span></label>
                        <select id="category" class="form-select" name="status">
                            <option {{old('status', $getRecord->status) == 'Ready to Dispatch' ? 'selected' : ''}} value="Ready to Dispatch">Ready to Dispatch</option>
                            <option {{old('status', $getRecord->status) == 'Dispatched' ? 'selected' : ''}} value="Dispatched">Dispatched</option>
                            <option {{old('status', $getRecord->status) == 'Online' ? 'selected' : ''}} value="Online">Online</option>
                            <option {{old('status', $getRecord->status) == 'Hold' ? 'selected' : ''}} value="Hold">Hold</option>
                           
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">File Uploaded by <span style="color: red;">*</span></label>
                        <input type="Text" readonly class="form-control" id="inputName5" value="{{$getRecord->created_by}}"
                            name="created_by" required>
                    </div>
                    <div class="col-4">
                        <label for="inputAddress2" class="form-label">Uploaded Date</label>
                        <input type="text" readonly class="form-control" id="address" name="created_at"
                            value="{{$getRecord->created_at}}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Last Updated by <span style="color: red;">*</span></label>
                        <input type="Text" readonly class="form-control" id="inputName5" value="{{$getRecord->updated_by}}"
                            name="updated_by" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Last Updated date <span style="color: red;">*</span></label>
                        <input type="Text"readonly class="form-control" id="inputName5" value="{{$getRecord->updated_at}}"
                            name="updated_at" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile_number" class="form-label">Remarks <span style="color: red;">*</span></label>
                        <input type="Text" class="form-control" id="remarks" value="{{$getRecord->remarks}}"
                            name="remarks" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>

                    </div>
                </form>

            </div>
        </div>



        </div>
    @endsection

    @section('script')
    @endsection
