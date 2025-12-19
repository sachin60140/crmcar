@extends('admin.layouts.app')
@section('title', 'View Booking | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        /* Table Aesthetics */
        table.dataTable thead th {
            background-color: #f8f9fa;
            color: #444;
            font-weight: 600;
            font-size: 13px;
        }
        .table-font-sm td { 
            font-size: 13px; 
            vertical-align: middle; 
        }
        
        /* Filter Box Design */
        .filter-box { 
            background: #ffffff; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border: 1px solid #efecec;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03); 
        }

        /* Column Search Inputs */
        thead input { 
            width: 100%; 
            padding: 4px 8px; 
            box-sizing: border-box; 
            font-size: 12px; 
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Custom Loading Spinner */
        .dataTables_processing {
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%);
            z-index: 11000 !important;
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #eee !important;
            border-radius: 8px;
            height: auto !important;
            padding: 15px 30px;
            font-weight: bold;
            color: #0d6efd;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Spinner Animation */
        .spinner-border-sm {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 0.2em;
        }
    </style>
@endsection

@section('content')
<div class="pagetitle mb-4">
    <h1>View Booking</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">View Booking</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            
            {{-- DATE FILTERS --}}
            <div class="filter-box">
                <h5 class="card-title pt-0 pb-3">Filter Options</h5>
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
                            <button type="button" id="filter" class="btn btn-primary btn-sm px-4">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                            <button type="button" id="refresh" class="btn btn-light btn-sm px-3 border">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA TABLE --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover text-nowrap display table-font-sm" id="booking_table" style="width:100%">
                    <thead class="table-light">
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

{{-- CANCEL BOOKING MODAL --}}
<div class="modal fade" id="cancelModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Cancel Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cancelBookingForm">
                @csrf 
                <div class="modal-body">
                    <input type="hidden" id="cancel_booking_id" name="id">
                    <div class="alert alert-warning small">
                        <strong>Warning:</strong> This will reverse the ledger entry and release the car stock.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Reason for Cancellation <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="cancel_reason" required rows="3" placeholder="E.g. Customer requested refund due to..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm" id="btnConfirmCancel">Confirm Cancellation</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function() {
    
    // 1. SET DEFAULT DATES
    const setDateDefaults = () => {
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

        $('#from_date').val(defaultFromDate);
        $('#to_date').val(currentDate);
    };
    setDateDefaults(); // Run on load

    // 2. INITIALIZE DATATABLE
    const nf = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', minimumFractionDigits: 0 });

    var table = $('#booking_table').DataTable({
        pageLength: 50,
        processing: true,
        serverSide: true,
        language: {
            processing: '<div class="spinner-border text-primary spinner-border-sm" role="status"></div><span class="ms-2">Loading Data...</span>'
        },
        order: [[12, 'desc']],
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
                render: function(data) { return data ? nf.format(data) : '0'; } 
            },
            { 
                data: 'adv_amount', 
                render: function(data) { return data ? '<span class="text-success fw-bold">' + nf.format(data) + '</span>' : '0'; } 
            },
            { 
                data: 'finance_amount', 
                render: function(data) { return data ? nf.format(data) : '0'; } 
            },
            { 
                data: 'due_amount', 
                render: function(data) { return data ? '<span class="text-danger">' + nf.format(data) + '</span>' : '0'; } 
            },
            { data: 'remarks', name: 'car_booking.remarks' },
            { data: 'created_at', name: 'car_booking.created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm', text: '<i class="bi bi-file-earmark-excel"></i> Excel' },
            { extend: 'pdf', className: 'btn btn-danger btn-sm', text: '<i class="bi bi-file-earmark-pdf"></i> PDF' }
        ]
    });

    // Apply styles to DataTables buttons manually after init
    table.buttons().container().appendTo( '#booking_table_wrapper .col-md-6:eq(0)' );

    // 3. SEARCH INPUT LOGIC
    $('#booking_table thead .search-row th').each(function (i) {
        var title = $(this).text();
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });

    // 4. FILTER ACTIONS
    $('#filter').click(function() { table.draw(); });
    $('#refresh').click(function() { setDateDefaults(); table.draw(); });

    // ===========================================
    // 5. CANCEL BOOKING LOGIC
    // ===========================================
    
    // A. Open Modal & Pass ID
    $(document).on('click', '.btn-cancel-booking', function() {
        var id = $(this).data('id'); // Get ID from button data-attribute
        $('#cancel_booking_id').val(id); // Set ID in Hidden Input
        $('#cancelBookingForm')[0].reset(); // Clear previous text
        $('#cancelModal').modal('show'); // Show Modal
    });

    // B. Submit Form via AJAX
    $('#cancelBookingForm').submit(function(e) {
        e.preventDefault();
        
        var submitBtn = $('#btnConfirmCancel');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: "{{ url('/admin/insert-cancel-booking') }}", // Ensure this route matches your web.php
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#cancelModal').modal('hide');
                submitBtn.prop('disabled', false).text(originalText);
                
                if (response.status == 'success') {
                    alert(response.message); // Or use Toast/SweetAlert if available
                    table.ajax.reload(null, false); // Reload Table
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).text(originalText);
                alert('Something went wrong. Please check console.');
                console.log(xhr.responseText);
            }
        });
    });

});
</script>
@endsection