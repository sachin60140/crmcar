@extends('admin.layouts.app')
@section('title', 'View Booking | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        .table-font-sm { font-size: 13px; }
        .filter-box { background: #f6f9ff; padding: 15px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #e0e0e0; }
        thead input { width: 100%; padding: 3px; box-sizing: border-box; font-size: 12px; }
    </style>
    <style>
    /* Position the DataTable processing indicator */
    .dataTables_processing {
        top: 60px !important;
        z-index: 11000 !important;
        background: rgba(255, 255, 255, 0.9) !important;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border: 1px solid #ddd !important;
        border-radius: 4px;
        height: 60px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #007bff;
    }

    /* Create a spinning animation */
    .dataTables_processing:after {
        content: "";
        border: 4px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="pagetitle">
    <h1>View Booking</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Booking Details</h5>

            {{-- DATE FILTERS --}}
            <div class="filter-box">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="fw-bold">From Date</label>
                        <input type="date" id="from_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">To Date</label>
                        <input type="date" id="to_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="filter" class="btn btn-primary btn-sm">Filter</button>
                        <button type="button" id="refresh" class="btn btn-secondary btn-sm">Reset</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display table-font-sm" id="booking_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created By</th>
                            <th>Booking No.</th>
                            <th>Customer Name</th>
                            <th>Reg No</th>
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
                        {{-- SEARCH-WISE ROW --}}
                        <tr class="search-row">
                            <th></th>
                            <th><input type="text" placeholder="User"></th>
                            <th><input type="text" placeholder="Booking #"></th>
                            <th><input type="text" placeholder="Name"></th>
                            <th><input type="text" placeholder="Reg"></th>
                            <th><input type="text" placeholder="Model"></th>
                            <th><input type="text" placeholder="Person"></th>
                            <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                        </tr>
                    </thead>
                </table>
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
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function() {
    // 1. SET DEFAULT DATES (Last 90 Days)
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    var currentDate = yyyy + '-' + mm + '-' + dd;

    var priorDate = new Date(new Date().setDate(today.getDate() - 90));
    var p_dd = String(priorDate.getDate()).padStart(2, '0');
    var p_mm = String(priorDate.getMonth() + 1).padStart(2, '0');
    var p_yyyy = priorDate.getFullYear();
    var defaultFromDate = p_yyyy + '-' + p_mm + '-' + p_dd;

    // Set values into the input boxes
    $('#from_date').val(defaultFromDate);
    $('#to_date').val(currentDate);

    // 2. INITIALIZE DATATABLE
    const nf = new Intl.NumberFormat('en-IN');

    var table = $('#booking_table').DataTable({
        processing: true,
        serverSide: true,
        language: {
        // Customize the loading text
        processing: '<span>Fetching Data...</span>'
    },
        order: [[0, 'desc']],
        ajax: {
            url: "{{ url()->current() }}",
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_by', name: 'car_booking.created_by' },
            { data: 'booking_no', name: 'car_booking.booking_no' },
            { data: 'name', name: 'ledger.name' },
            { data: 'regnumber', name: 'car_stock.reg_number' },
            { data: 'carmodel', name: 'car_stock.car_model' },
            { data: 'booking_person', name: 'car_booking.booking_person' },
            { 
                data: 'total_amount', 
                render: function(data) { return nf.format(data || 0); } 
            },
            { 
                data: 'adv_amount', 
                render: function(data) { return nf.format(data || 0); } 
            },
            { 
                data: 'finance_amount', 
                render: function(data) { return nf.format(data || 0); } 
            },
            { 
                data: 'due_amount', 
                render: function(data) { return nf.format(data || 0); } 
            },
            { data: 'remarks', name: 'car_booking.remarks' },
            { data: 'created_at', name: 'car_booking.created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf']
    });

    // 3. FILTER ACTIONS
    $('#filter').click(function() {
        table.draw();
    });

    $('#refresh').click(function() {
        $('#from_date').val(defaultFromDate);
        $('#to_date').val(currentDate);
        table.draw();
    });
});
</script>
@endsection