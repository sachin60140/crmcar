@extends('admin.layouts.app')

@section('title', 'Create Finance File | Car 4 Sale')


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
                <li class="breadcrumb-item active">Add Finance File</li>
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
                        <h5 class="card-title">Add Finance File</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{route('storefinancefiledetails')}}" method="POST">
                            @csrf
                            
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Name of Customer <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="cutomer_name"
                                    value="{{ old('cutomer_name') }}" name="cutomer_name" autofocus required>
                            </div>
                            <div class="col-md-12">
                                <label for="due_amount" class="form-label">Mobile Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="mobile"
                                    value="{{ old('mobile') }}" name="mobile" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Customer Pan Card <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="cutomer_pan"
                                    value="{{ old('cutomer_pan') }}" name="cutomer_pan" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Aadhar Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="aadhar"
                                    value="{{ old('aadhar') }}" name="aadhar" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Address <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="address"
                                    value="{{ old('address') }}" name="address" required>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Vehicle Registration Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="reg_number"
                                    value="{{ old('reg_number') }}" name="reg_number" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">RTO <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="rto_name"
                                    value="{{ old('rto_name') }}" name="rto_name" required>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Financer</label>

                               
                                <select class="form-select" name="financer_details_id">
                                    <option value="">Select Financer Name...</option>
                                    @foreach ($financer_list as $item )
                                        <option value="{{$item->id}}">{{$item->financer_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Booking Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="booking_amount"
                                    value="{{ old('booking_amount') }}" name="booking_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="due_amount" class="form-label">Finance Amount <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="finance_amount"
                                    value="{{ old('finance_amount') }}" name="finance_amount" required>
                            </div>
                            <div class="col-md-12">
                                <label for="total_amount" class="form-label">Remark's </label>
                                <input type="Text" class="form-control" id="finance_remarks"
                                    value="{{ old('finance_remarks') }}" name="finance_remarks" required>
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
