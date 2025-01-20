@extends('admin.layouts.app')

@section('title', 'View Inspection Report | Car 4 Sale')


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
            <li class="breadcrumb-item active">View Inspection</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section dashboard">

    <div class="card">
        <div class="card-body text-center">
            <h5 class="card-title mb-3 ">View Inspection</h5>

            <!-- Multi Columns Form -->
            <form class="row g-3" action="">
               
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Search Number<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ old('reg_number') }}" name="reg_number" autofocus require>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>

        </div>
        <div class="p-3">
            <div class="row row-cols-1 row-cols-md-4 g-4">

                @forelse ($inspection as $item)
                <div class="col">
                    <div class="card">
                        <img src="{{asset('upload/inspection')}}/{{$item->pur_ins_image}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->reg_number }}</h5>
                            <p class="card-text">Purchase Date: {{ $item->purchase_date }}</p>
                            <p class="card-text">Vendor Name: {{ $item->vendor_name }}</p>
                            <p class="card-text">Vendor Mobile: {{ $item->vendor_mobile }}</p>
                            <p class="card-text">Remarks: {{ $item->remarks }}</p>
                            
                        </div>
                    </div>
                </div>
                @empty
                <p >No Details Found</p>
                @endforelse
            </div>
        </div>
    </div>



    </div>
    @endsection

    @section('script')
    @endsection