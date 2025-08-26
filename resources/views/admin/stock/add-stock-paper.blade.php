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
                            <div id="product-fields">
                                <div class="row product-entry mb-3">
                                    <div class="col-md-5">
                                        <input type="text" name="products[0][name]" class="form-control" placeholder="Product Name" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" name="products[0][price]" class="form-control" placeholder="Price" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-product-field" class="btn btn-primary">Add More Products</button>
                            <button type="submit" class="btn btn-success">Save Products</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @endsection

    @section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let productIndex = 1;

            $('#add-product-field').click(function() {
                let newField = `
                <div class="row product-entry mb-3">
                    <div class="col-md-5">
                        <input type="text" name="products[${productIndex}][name]" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="products[${productIndex}][price]" class="form-control" placeholder="Price" step="0.01" required>
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