@extends('admin.layouts.app')

@section('title', 'Update Finance File | Car 4 Sale')


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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item active">Update Finance File</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-6 mx-auto">
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
                        <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update Finance File</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{route('updatefilestatus')}}" method="POST">
                            @csrf
                            <div class="col-md-12" hidden>
                                <input type="Text" class="form-control" id="cutomer_id"
                                    value="{{$updatefinancefiledetails['0']['id']}}" name="cutomer_id" autofocus required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Name of Customer <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="cutomer_name"
                                    value="{{$updatefinancefiledetails['0']['cutomer_name']}}" name="cutomer_name" autofocus required>
                            </div>
                            <div class="col-md-12">
                                <label for="due_amount" class="form-label">Mobile Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="mobile"
                                    value="{{$updatefinancefiledetails['0']['mobile']}}" name="mobile" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Customer Pan Card <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="cutomer_pan"
                                    value="{{$updatefinancefiledetails['0']['cutomer_pan']}}" name="cutomer_pan" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Aadhar Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="aadhar"
                                    value="{{$updatefinancefiledetails['0']['aadhar']}}" name="aadhar" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Address <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="address"
                                    value="{{$updatefinancefiledetails['0']['address']}}" name="address" required>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Vehicle Registration Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="reg_number"
                                    value="{{$updatefinancefiledetails['0']['reg_number']}}" name="reg_number" readonly required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">RTO <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="rto_name"
                                    value="{{$updatefinancefiledetails['0']['rto_name']}}" name="rto_name" readonly required>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">RC Available Status</label>
                                <select class="form-select" name="rc_status">
                                    <option value="">Select Rc Status...</option>
                                    <option {{(old('rc_status',$updatefinancefiledetails['0']['rc_status'])== 'Available') ? 'selected' : ''}} value="Available">Available</option>
                                    <option {{(old('rc_status',$updatefinancefiledetails['0']['rc_status'])== 'Not - Available') ? 'selected' : ''}} value="Not - Available">Not - Available</option>
                                    
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Insurance Available Status</label>
                                <select class="form-select" name="Insurance_status">
                                    <option value="">Select Insurance Status...</option>
                                    <option {{(old('Insurance_status',$updatefinancefiledetails['0']['Insurance_status'])== 'Available') ? 'selected' : ''}} value="Available">Available</option>
                                    <option {{(old('Insurance_status',$updatefinancefiledetails['0']['Insurance_status'])== 'Not - Available') ? 'selected' : ''}} value="Not - Available">Not - Available</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">NOC Status</label>
                                <select class="form-select" name="noc_Status">
                                    <option {{(old('noc_Status',$updatefinancefiledetails['0']['noc_Status'])== 'CASH') ? 'selected' : ''}} value="CASH">CASH</option>
                                    <option {{(old('noc_Status',$updatefinancefiledetails['0']['noc_Status'])== 'NOC') ? 'selected' : ''}} value="NOC">NOC</option>
                                    <option {{(old('noc_Status',$updatefinancefiledetails['0']['noc_Status'])== 'Closer') ? 'selected' : ''}} value="Closer">Closer</option>
                                    <option {{(old('noc_Status',$updatefinancefiledetails['0']['noc_Status'])== 'Not - Available') ? 'selected' : ''}} value="Not - Available">Not - Available</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Financer</label>
                                <select class="form-select" name="financer_details_id">
                                    <option value="">Select Financer Name...</option>
                                    @foreach ($financer_details as $items)
                                    <option {{old('financer_details_id', $updatefinancefiledetails['0']['financer_details_id'])==$items->id ? 'selected' : ''}} value="{{ $items->id }}">{{ $items->financer_name }}</option>
                                @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Finance Code <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="fiance_code"
                                    value="{{$updatefinancefiledetails['0']['fiance_code']}}" name="fiance_code" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Sales Executive <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="sales_executive"
                                    value="{{$updatefinancefiledetails['0']['sales_executive']}}" name="sales_executive" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Sales Executive Mobile Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="se_mobile"
                                    value="{{$updatefinancefiledetails['0']['se_mobile']}}" name="se_mobile" required>
                            </div>

                            <hr>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Sold Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="sold_amount"
                                    value="{{$updatefinancefiledetails['0']['sold_amount']}}" name="sold_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Booking Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="booking_amount"
                                    value="{{$updatefinancefiledetails['0']['booking_amount']}}" name="booking_amount" readonly required>
                            </div>
                            <div class="col-md-12">
                                <label for="due_amount" class="form-label">Finance Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="finance_amount"
                                    value="{{$updatefinancefiledetails['0']['finance_amount']}}" name="finance_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">File Status</label>
                                <select class="form-select" name="file_status">
                                    @foreach ($file_status as $items)
                                    <option {{old('file_status', $updatefinancefiledetails['0']['file_status'])==$items->id ? 'selected' : ''}} value="{{ $items->id }}">{{ $items->file_status_type }}</option>
                                @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Remark's </label>
                                <input type="Text" class="form-control" id="finance_remarks_update"
                                    value="{{old('finance_remarks_update')}}" name="finance_remarks_update" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection

    @section('script')
        
    @endsection
