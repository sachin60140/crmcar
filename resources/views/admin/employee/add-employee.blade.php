@extends('admin.layouts.app')

@section('title', 'Add Employee | Car 4 Sale')


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
                <li class="breadcrumb-item active">Add Employee</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Employee</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ route('storebooking') }}" method="POST">
                            @csrf
                            
                            <div class="col-md-12">
                                <label for="Name" class="form-label">Name of Employee <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="emp_name"
                                    value="{{ old('emp_name') }}" name="emp_name" required>
                            </div>
                            <div class="col-md-12">
                                <label for="adv_amount" class="form-label">Mobile Number <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="emp_mobile"
                                    value="{{ old('emp_mobile') }}" name="emp_mobile" required>
                            </div>
                            <div class="col-md-12">
                                <label for="due_amount" class="form-label">Password <span
                                        style="color: red;">*</span></label>
                                <input type="Text" class="form-control" id="password"
                                    value="{{ old('password') }}" name="password" required>
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
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script>
            $(function() {
                $('#total_amount, #adv_amount').keyup(function() {
                    var value1 = parseFloat($('#total_amount').val()) || 0;

                    var value2 = parseFloat($('#adv_amount').val()) || 0;
                    $('#due_amount').val(value1 - value2);
                });
            });
        </script>



    @endsection
