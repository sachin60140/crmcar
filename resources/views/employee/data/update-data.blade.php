@extends('employee.layouts.app')

@section('title', 'Update Data | Car 4 Sale')

@section('style')

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* .hidden {
            display: none;
        }

        .show {
            display: block;
        } */
    </style>

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Employee Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employee/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item active">Data</li>
                <li class="breadcrumb-item active">Add Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12 mx-auto">
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
                        <h5 class="card-title">Update Lead Data</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ url('employee/data/store-update-lead/' . $lead_data->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="fee" class="form-label">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="cab_fee" value="{{ $lead_data->Name }}"
                                    name="name">
                            </div>
                            <div class="col-md-6">
                                <label for="mobile_number" class="form-label">Mobile <span
                                        style="color: red;">*</span></label>
                                <input type="tel" class="form-control" id="inputName5"
                                    value="{{ $lead_data->mobile_number }}" name="mobile_number" maxlength="10" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Lead Type</label>
                                <select id="calling_status" class="form-select" name="calling_status">
                                    @foreach ($calling_status as $item)
                                        <option
                                            {{ old('calling_status', $lead_data->lead_status) == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->calling_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="hidden col-md-12" id="pDetails">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="mobile_number" class="form-label">Enquire Car Details <span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="enquiry_car_details"
                                            value="{{ old('enquiry_car_details') }} {{ $lead_data->enquiry_car_details }}" name="enquiry_car_details">
                                    </div>

                                    <div class="col-md-6 lead_category">
                                        <label for="category" class="form-label">Lead Category</label>
                                        <select id="category" class="form-select" name="lead_category">
                                            @foreach ($lead_category as $items)
                                                <option
                                                    {{ old('lead_category', $lead_data->lead_type) == $items->lead_type ? 'selected' : '' }}
                                                    value="{{ $items->lead_type }}">{{ $items->lead_type }}</option>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress2" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Apartment, studio, or floor" value="{{ $lead_data->address }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress2" class="form-label">Next Folloup</label>
                                        <input type="date" class="form-control" id="next_folloup" name="next_folloup"
                                            value="{{ old('next_folloup') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remark" name="remark"
                                    placeholder="Enter Valid Remarks" value="{{ old('remark') }}" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>

                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Remarks Status </h5>
                            <div class="row">
                                <div class="col">
                                   <table class="table">
                                    <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Remarks</th>
                                          <th scope="col">Next Follow-Up </th>
                                          
                                          <th scope="col">Last Updated</th>
                                          <th scope="col">Entry by</th>
                                          
                                        </tr>
                                      </thead>
                                        <tbody>
                                            @foreach ($remarks as $remark_stage )
                                                <tr>
                                                    <td>{{$remark_stage->id}}</td>
                                                    <td>{{ucwords($remark_stage->cus_remarks)}}</td>
                                                    <td>{{date('d-M-Y', strtotime(($remark_stage->next_folloup_date)))}}</td>
                                                    
                                                    <td>{{date('d-M-Y H:i:s', strtotime(($remark_stage->created_at)))}}</td>
                                                    <td>{{$remark_stage->created_by}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        
                                   </table>
                                </div>
                            </div>
    
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
        </div>
    @endsection

    @section('script')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        {{-- <script>
            $(document).ready(function() {

                $("#calling_status").change(function() {
                    var id = $(this).val();

                    if (id == '3') {
                        $('#pDetails').removeClass("show");
                        $('#pDetails').addClass("hidden");
                        console.log(id);
                    } else if (id == '4') {
                        $('#pDetails').removeClass("show");
                        $('#pDetails').addClass("hidden");
                    } else if (id == '5') {
                        $('#pDetails').removeClass("show");
                        $('#pDetails').addClass("hidden");
                    } else if (id == '10') {
                        $('#pDetails').removeClass("show");
                        $('#pDetails').addClass("hidden");
                    } else {
                        $('#pDetails').removeClass("hidden");
                        $('#pDetails').addClass("show");
                    }
                });
            });
        </script>
 --}}


    @endsection
