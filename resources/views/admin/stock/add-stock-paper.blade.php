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
                            <h4 class="mb-0">Create Item with Dynamic Fields</h4>
                        </div>

                        <div class="card-body mt-4">
                            <form action="" method="POST" id="dynamicForm">
                                @csrf
                                <div class="row">
                                    <div class="row product-entry mb-3">
                                        <div class="col-md-6">
                                            <label for="Stock_Doc" class="mb-3">Registration Number</label>
                                            <input type="text" name="File_Name[0][file_name]" class="form-control"
                                                placeholder="Registration Number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Stock_Doc" class="mb-3">Model Name</label>
                                            <input type="text" name="File_Name[0][file_name]" class="form-control"
                                                placeholder="Model Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="product-fields">
                                    <div class="row product-entry mb-3">
                                        <div class="col-md-5">
                                            <input type="text" name="File_Name[0][file_name]" class="form-control"
                                                placeholder="File Name" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" name="Stock_Doc[0][stock_doc]" class="form-control"
                                                placeholder="Upload File" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-danger remove-product-field">Remove</button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-product-field" class="btn btn-primary">Add More
                                    Products</button>
                                <button type="submit" class="btn btn-success">Save Products</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let File_Name_index = 1;
            let File_index = 1;

            $('#add-product-field').click(function() {
                let newField = `
                <div class="row product-entry mb-3">
                    <div class="col-md-5">
                        <input type="text" name="File_Name[${File_Name_index}][name]" class="form-control" placeholder="File Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="file" name="Stock_Doc[${File_index}][stock_doc]" class="form-control"  required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                    </div>
                </div>`;
                $('#product-fields').append(newField);
                productIndex++;
            });

            $('#product-fields').on('click', '.remove-product-field', function() {
                $(this).closest('.product-entry').remove();
            });
        });
    </script>

@endsection
