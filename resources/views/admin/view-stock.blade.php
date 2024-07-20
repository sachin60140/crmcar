@extends('admin.layouts.app')

@section('title', 'View Stock | Car 4 Sales')


@section('style')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">View Stock</li>
                
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Stock </h5>
                    

                        <!-- Table with stripped rows -->
                        <table class="table display" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Model Name</th>
                                    <th scope="col">Registration Number</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Fuel</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Owner Sl No</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Last Price</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->branch }}</td>
                                        <td>{{ $items->car_model }}</td>
                                        <td>{{ $items->reg_number }}</td>
                                        <td>{{ $items->car_model_year }}</td>
                                        <td>{{ $items->fuel_type }}</td>
                                        <td>{{ $items->color }}</td>
                                        <td>{{ $items->owner_sl_no }}</td>
                                        <td>{{ $items->price }}</td>
                                        <td>{{ $items->lastprice }}</td>
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>

    @endsection

    @section('script')
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    "pageLength": 50,

                    "aaSorting": [
                        [2, 'asc']
                    ],
                });
            });
        </script>
    @endsection
