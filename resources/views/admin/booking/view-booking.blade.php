@extends('admin.layouts.app')

@section('title', 'View Booking | Car 4 Sales')


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
                <li class="breadcrumb-item">View Booking</li>

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
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Booking Details </h5>
                        {{-- <h5 class="card-title"><a href="{{url("admin/employee/generate-pdf")}}" target="_blank" > click me to pdf </a></h5> --}}

                        <!-- Table with stripped rows -->
                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Booking by</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Reg</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Booking by</th>
                                    <th scope="col">Sell </th>
                                    <th scope="col">Booking</th>
                                    <th scope="col">Finance</th>
                                    <th scope="col">DP</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Print</th>
                                    <th scope="col">Delivary</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carbooking as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->created_by }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->regnumber }}</td>
                                        <td>{{ $items->carmodel }}</td>
                                        <td>{{ $items->booking_person }}</td>
                                        <td>{{ $items->total_amount }}</td>
                                        <td>{{ $items->adv_amount }}</td>
                                        <td>{{ $items->finance_amount }}</td>
                                        <td>{{ $items->due_amount }}</td>
                                        <td>{{ $items->remarks }}</td>
                                        <td>{{ date('d-M-Y', strtotime($items->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('/admin/print-booking-pdf') }}/{{ $items->id }}"
                                                class="badge bg-primary">Print </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/delivary/add-delivary') }}/{{ $items->id }}"
                                                class="badge bg-success">Delivary </a>
                                        </td>

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

        {{-- <script>
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
                        [0, 'desc']
                    ],
                });
            });
        </script> --}}


        <script>
            $(document).ready(function() {

                // 1. Get current date
                var d = new Date();

                // 2. Format to DD-MM-YYYY
                var strDate = d.getDate().toString().padStart(2, '0') + "-" +
                    (d.getMonth() + 1).toString().padStart(2, '0') + "-" +
                    d.getFullYear();

                // Result example: "25-11-2025"

                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5', // Simple button (no custom name)
                        {
                            extend: 'excelHtml5',
                            title: 'Booking Report Car4Sales - ' +
                            strDate, // Sets filename to "My Custom Report Name.xlsx"
                            messageTop: 'The data in this file is strictly confidential.' // Optional: Text inside the file
                        },
                        {
                            extend: 'csvHtml5',
                            title: 'Booking Report Car4Sales - ' +
                                strDate // Sets filename to "My Custom Report Name.csv"
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Booking Report Car4Sales - ' +
                                strDate // Sets filename to "My Custom Report Name.pdf"
                        }
                    ],
                    "pageLength": 50,
                    "aaSorting": [
                        [0, 'desc']
                    ],
                });
            });
        </script>
    @endsection
