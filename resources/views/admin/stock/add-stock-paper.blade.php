@extends('admin.layouts.app')

@section('title', 'Add Stock Paper | Car 4 Sale')


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
                <li class="breadcrumb-item active">DTO</li>
                <li class="breadcrumb-item active">Add Stock Paper</li>
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
                <h5 class="card-title">Upload Stock Paper</h5>

                <div class="container mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 text-center">Upload Stock Paper</h4>
                        </div>

                        <div class="card-body mt-4">
                            <form action="{{ route('storestockpaper') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="row product-entry mb-3">
                                        <div class="col-md-4 mb-3">
                                            <label for="category" class="form-label">Reg Number</label>
                                            <select id="reg_number" class="form-select" name="reg_number">
                                                <option value="" selected>Choose...</option>
                                                @foreach ($car_stock as $item)
                                                    <option value="{{ $item->reg_number }}" @selected(old('reg_number') == $item->reg_number)>
                                                        {{ $item->reg_number }}- {{ $item->car_model }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="category" class="form-label">Doc Type</label>
                                            <select id="doc_type" class="form-select" name="doc_type">
                                                <option value="" selected>Choose...</option>
                                                @foreach ($stock_paper_cat as $item_type)
                                                    <option value="{{ $item_type->doc_type }}" @selected(old('doc_type') == $item_type->doc_type)>
                                                        {{ $item_type->doc_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="category" class="form-label">Choose File</label>
                                            <input type="file" name="stock_doc" class="form-control"
                                                placeholder="Upload File" required>
                                        </div>
                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Upload Files</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('script')
   

@endsection
