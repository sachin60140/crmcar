@extends('admin.layouts.app')
@section('title', 'Cancelled Bookings | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        table.dataTable thead th { background-color: #f8f9fa; color: #444; font-size: 13px; }
        .table-font-sm td { font-size: 13px; vertical-align: middle; }
        .filter-box { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #efecec; }
        thead input { width: 100%; padding: 4px; font-size: 12px; border: 1px solid #ddd; border-radius: 4px; }
        .dataTables_processing {
            top: 50% !important; left: 50% !important; transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.95) !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-weight: bold; color: #dc3545; display: flex; align-items: center; gap: 10px; padding: 15px 30px;
        }
    </style>
@endsection

@section('content')
<div class="pagetitle mb-4">
    <h1>Cancelled Bookings History</h1>
</div>

<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            
            {{-- DATE FILTERS --}}
            <div class="filter-box">
                <h5 class="card-title pt-0 pb-3 text-danger">Filter Cancelled Records</h5>
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">From Date</label>
                        <input type="date" id="from_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">To Date</label>
                        <input type="date" id="to_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="button" id="filter" class="btn btn-danger btn-sm px-4">Filter</button>
                            <button type="button" id="refresh" class="btn btn-light btn-sm px-3 border">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA TABLE --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover text-nowrap display table-font-sm" id="cancelled_table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cancel Date</th>
                            <th>Booking No</th>
                            <th>Customer Name</th>
                            <th>Reg No</th>
                            <th>Car Model</th>
                            <th>Refund Amt</th>
                            <th>Reason</th>
                            <th>Cancelled By</th>
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
    // 1. Set Default Dates
    const setDateDefaults = () => {
        var today = new Date();
        var priorDate = new Date(new Date().setDate(today.getDate() - 90));
        $('#from_date').val(priorDate.toISOString().split('T')[0]);
        $('#to_date').val(today.toISOString().split('T')[0]);
    };
    setDateDefaults();

    // 2. Initialize DataTable
    var table = $('#cancelled_table').DataTable({
        pageLength: 50,
        processing: true,
        serverSide: true,
        language: { processing: '<div class="spinner-border text-danger spinner-border-sm" role="status"></div><span class="ms-2">Loading History...</span>' },
        order: [[1, 'desc']], 
        ajax: {
            url: "{{ url()->current() }}",
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_at', name: 'cancelled_booking_models.created_at' },
            { data: 'booking_no', name: 'cancelled_booking_models.booking_no' },
            { data: 'customer_name', name: 'ledger.name' },
            { data: 'reg_number', name: 'car_stock.reg_number' },
            { data: 'car_model', name: 'car_stock.car_model' },
            { data: 'refund_amount', name: 'cancelled_booking_models.refund_amount', className: 'text-end fw-bold text-danger' },
            { data: 'cancel_reason', name: 'cancelled_booking_models.cancel_reason' },
            { data: 'cancelled_by', name: 'cancelled_booking_models.cancelled_by' }
        ],
        dom: 'Brtip', // 'f' removed to hide global search box
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm', text: 'Excel' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm', text: 'PDF' }
        ]
    });

    table.buttons().container().appendTo( '#cancelled_table_wrapper .col-md-6:eq(0)' );

    // 3. Search Inputs
    $('#cancelled_table thead .search-row th').each(function (i) {
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });

    // 4. Filter Buttons
    $('#filter').click(function() { table.draw(); });
    $('#refresh').click(function() { setDateDefaults(); table.draw(); });
});
</script>
@endsection