@extends('admin.layouts.app')
@section('title', 'View Booking | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        .table-font-sm { font-size: 13px; }
        .filter-box { background: #f6f9ff; padding: 15px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #e0e0e0; }
        /* Optional: Hide the processing loader background if it conflicts with theme */
        .dataTables_processing { z-index: 1000; background-color: rgba(255,255,255,0.9); }
    </style>
@endsection

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">View Booking</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Booking Details</h5>

                    {{-- DATE SEARCH INPUTS --}}
                    <div class="filter-box">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="from_date" class="form-label fw-bold">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label fw-bold">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="filter" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <button type="button" id="refresh" class="btn btn-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END DATE SEARCH INPUTS --}}

                    <div class="table-responsive">
                        <table class="table display table-font-sm" id="booking_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Booking No.</th>
                                    <th>Name</th>
                                    <th>Reg</th>
                                    <th>Model</th>
                                    <th>Booking Person</th>
                                    <th>Sell</th>
                                    <th>Booking</th>
                                    <th>Finance</th>
                                    <th>Due</th>
                                    <th>Remarks</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

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

        // --- 1. Date Logic (Defaults to Last 90 Days) ---
        var today = new Date();
        var priorDate = new Date(new Date().setDate(today.getDate() - 90));

        // Helper: Format Date to YYYY-MM-DD
        var formatDate = function(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        };

        // Helper: Format Date to DD-MM-YYYY for File Name
        var strDate = String(today.getDate()).padStart(2, '0') + '-' + 
                      String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                      today.getFullYear();

        // Set Input Values
        $('#from_date').val(formatDate(priorDate));
        $('#to_date').val(formatDate(today));


        // --- 2. Initialize DataTable ---
        var table = $('#booking_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url()->current() }}",
                data: function(d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'created_by', name: 'created_by' },
                { data: 'booking_no', name: 'booking_no' },
                
                // SAFETY: defaultContent prevents crashing if data is missing
                { data: 'name', name: 'name', defaultContent: "-" }, 
                { data: 'regnumber', name: 'regnumber', defaultContent: "-" },
                { data: 'carmodel', name: 'carmodel', defaultContent: "-" },
                
                { data: 'booking_person', name: 'booking_person', defaultContent: "-" },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'adv_amount', name: 'adv_amount' },
                { data: 'finance_amount', name: 'finance_amount' },
                { data: 'due_amount', name: 'due_amount' },
                { data: 'remarks', name: 'remarks', defaultContent: "" },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            dom: 'Bfrtip',
            order: [[0, 'desc']], // Sort by ID Descending
            pageLength: 50,
            buttons: [
                'copy', 
                {
                    extend: 'excel',
                    title: 'Booking Report ' + strDate
                },
                {
                    extend: 'csv',
                    title: 'Booking Report ' + strDate
                },
                {
                    extend: 'pdf',
                    title: 'Booking Report ' + strDate,
                    orientation: 'landscape',
                    exportOptions: { columns: ':not(:last-child)' } // Exclude Action column
                }
            ]
        });

        // --- 3. Filter Event ---
        $('#filter').click(function() {
            table.draw();
        });

        // --- 4. Reset Event ---
        $('#refresh').click(function() {
            // Restore default 90 days range
            $('#from_date').val(formatDate(priorDate));
            $('#to_date').val(formatDate(today));
            table.draw();
        });
    });
</script>
@endsection