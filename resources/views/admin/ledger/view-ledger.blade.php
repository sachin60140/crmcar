@extends('admin.layouts.app')

@section('title', 'View Lead Data | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        /* Optional: minor spacing adjustment for the table */
        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 8px 10px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">View Branch</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Branch</h5>

                        <div class="table-responsive">
                            <table class="table display" style="font-size: 13px;" id="example">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father's Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">PAN</th>
                                        <th scope="col">Aadhar</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Statement</th>
                                        <th scope="col">Added By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $items)
                                        <tr>
                                            <td>{{ $items->id }}</td>
                                            <td>{{ $items->name }}</td>
                                            <td>{{ $items->f_name }}</td>
                                            <td>{{ $items->mobile_number }}</td>
                                            <td>{{ $items->pan }}</td>
                                            <td>{{ $items->aadhar }}</td>
                                            <td style="text-align: right;">
                                                {{-- optimized: total_amount comes from controller --}}
                                                <span class="badge bg-success">
                                                    ₹{{ number_format($items->total_amount ?? 0, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/customer/view-ledger-statement/' . $items->id) }}"
                                                    class="btn btn-primary btn-sm" target="_blank" title="View Statement">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </a>
                                            </td>
                                            <td>{{ $items->created_by }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- 
      NOTE: I have commented out the main jQuery library. 
      Your layout 'admin.layouts.app' likely already loads jQuery.
      Loading it twice causes DataTables to crash.
      Uncomment the line below ONLY if your layout does NOT include jQuery.
    --}}
    {{--  --}}

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
                    'pdfHtml5'
                ],
                "pageLength": 50,
                "aaSorting": [
                    [0, 'desc'] // Default sort by ID descending
                ]
            });
        });
    </script>
@endsection
