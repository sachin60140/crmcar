@extends('admin.layouts.app')

@section('title', 'Lead Allotment| Car 4 Sale')


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
                <li class="breadcrumb-item active">Data</li>
                <li class="breadcrumb-item active">Lead Allotment</li>
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
                    <div class="card-body">
                        <h5 class="card-title">Lead Allotment</h5>
        
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{route('storeleadallotment')}}" method="POST">
                            @csrf
                            <div class="col-md-12 mb-3" >
                                <label for="category" class="form-label">Telecaller Name</label>
                                <select id="telecaller" class="form-select" name="telecaller">
                                    @foreach ($telecaller as $item)
                                        <option value="{{ $item->name }}" @selected(old('telecaller') == $item->id)>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="fee" class="form-label">Lead Quantity <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="lead_qty" value="{{ old('lead_qty') }}"
                                    name="lead_qty">
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
