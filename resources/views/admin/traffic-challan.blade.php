@extends('admin.layouts.app')

@section('title', 'Check Traffic Challan | Car4Sales')


@section('style')
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active">Traffic Challan</li>
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
                <h5 class="card-title">Check Traffic Challan</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" action="" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="car_number" class="form-label">Car Registration Number</label>
                        <input type="text" class="form-control" style="text-transform:uppercase" id="car_number"
                            name="car_number" placeholder="Enter Registration Number" value="{{ old('car_number') }}"
                            required>
                    </div>

                    <div class="text-center">
                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}

                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>



        </div>
    @endsection

    @section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script>
            $(function() {
                $(".car_number").keyup(function() {
                    $(this).val($(this).val().replace(/\s/g, ""));
                    
                });
            });
        </script>
    @endsection
