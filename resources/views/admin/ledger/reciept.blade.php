@extends('admin.layouts.app')

@section('title', 'Payment Reciept | Car 4 Sale')


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
                
                <li class="breadcrumb-item active">Reciept</li>
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
                    <div class="card-body bg-success bg-opacity-75">
                        <h5 class="card-title text-center text-white">Reciept Details</h5>
        
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{route('storerecieptpayment')}}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label for="empname" class="form-label text-white"><strong>Name</strong> </label>
                                <select class="form-select" name="client_name" id="client_name" autofocus>
                                    <option value="" selected >Select Client Ledger...</option>
                                    @foreach ($clientlist as $clients )
                                    <option {{old('client_name')==$clients->id ? 'selected' : ''}} value="{{ $clients->id }}">{{ $clients->name }}-{{ $clients->mobile_number }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="paymentMode" class="form-label">Payment Mode</label>
                                <select class="form-select" name="paymentMode">
                                    <option value="">Select Payment Mode...</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="amount" class="form-label text-white"><strong>Txn Date</strong></label>
                                <span class="text-danger" id="txn_date"></span>
                                <input type="date" class="form-control" name="txn_date" value="{{ old('txn_date') }}">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="amount" class="form-label text-white"><strong>Amount</strong></label>
                                <span class="text-danger" id="amount"></span>
                                <span class="text-white" id="dues"></span>
                                <input type="number" min="0.00" max="1500000.00" step="any" class="form-control" name="amount" value="{{ old('amount') }}">
                            </div>

                            <div class="col-md-12">
                                <label for="remarks" class="form-label text-white"><strong>Remarks</strong></label>
                                <input type="text" class="form-control" name="remarks" value="{{old('remarks')}}" >
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
        
                    </div>
                </div>
            </div>
        </div>
        



        </div>
    @endsection

    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
                $('#client_name').on('change', function() {
                    var customerid = $(this).val();
                    $.ajax({
                        url: '/admin/customer/getcustomerbalance',
                        type: 'post',
                        data: 'customerid=' + customerid + '&_token={{ csrf_token() }}',
                        success: function(result) {
                            $('#dues').html(result)
                        }
                    });

                });
            });
    </script>
    @endsection
