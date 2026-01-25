@extends('admin.layouts.app')

@section('title', 'View Delivery | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        /* Filter Form Styling */
        .filter-form {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filter-form .form-group {
            display: flex;
            flex-direction: column;
        }
        .filter-form label {
            font-weight: bold;
            font-size: 12px; /* Smaller label */
            margin-bottom: 5px;
            color: #555;
        }
        
        /* Table Compact Styling */
        table.dataTable thead th, table.dataTable tbody td {
            padding: 4px 8px; /* Reduce padding for smaller height */
            white-space: nowrap; /* Prevent text wrapping */
        }
        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
            overflow-y: hidden !important; /* Hide vertical scroll if not needed */
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Delivery</li>
                <li class="breadcrumb-item">View Delivery</li>
            </ol>
        </nav>
    </div>

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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Delivery Details</h5>

                        <form action="" method="GET" class="filter-form">
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" class="form-control form-control-sm" 
                                    value="{{ $start_date }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" class="form-control form-control-sm" 
                                    value="{{ $end_date }}">
                            </div>
                            
                            <div class="form-group" style="flex-direction: row; gap: 5px;">
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </form>

                        <table class="table table-striped table-sm display nowrap" style="width:100%; font-size: 12px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Added By</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Booking by</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Registration</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Sell Amount</th>                                    
                                    <th scope="col">Financer</th>
                                    <th scope="col">F Amount</th>
                                    <th scope="col">PDI Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cardelivary as $items)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ url('/admin/delivary/delivary_pdf') }}/{{ $items->id }}" target="_blank"> 
                                                {{ $items->booking_id }} 
                                            </a>
                                        </td>
                                        <td>{{ $items->added_by }}</td>
                                        <td>{{ date('d-M-Y', strtotime($items->created_at)) }}</td>
                                        <td>{{ $items->booking_person }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->mobile }}</td>
                                        <td>{{ $items->reg_number }}</td>
                                        <td>{{ $items->model_name }}</td>
                                        <td>{{ $items->model_year }}</td>
                                        <td>{{ $items->sell_amount }}</td>
                                        
                                        <td>{{ $items->financer }}</td>
                                        <td>{{ $items->finance_amount }}</td>
                                        <td>
                                            @if(!empty($items->pdi_image))
                                                <a href="{{ asset('upload/pdi/'.$items->pdi_image) }}" target="_blank">
                                                    <img src="{{ asset('upload/pdi/'.$items->pdi_image) }}" alt="PDI" width="30" height="30" style="object-fit:cover; border-radius: 4px;">
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                "scrollX": true,      // Enables horizontal scrolling
                "responsive": false,  // Disables collapsing columns
                "autoWidth": false,   // Prevents auto-calculation errors
                buttons: [
                    'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        title: 'Car_Delivery_Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'csvHtml5',
                    'pdfHtml5',
                ],
                "pageLength": 50,
                
            });
        });
    </script>
@endsection