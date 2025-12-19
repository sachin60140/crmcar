@extends('admin.layouts.app')

@section('title', 'View DTO File | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        /* Optional: Style the history modal table */
        #historyTable th {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">View DTO File</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    @if (Session::has('success'))
                        <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Dto File</h5>

                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">History</th>
                                    <th scope="col">Registration</th>
                                    <th scope="col">RTO</th>
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Vendor Mobile</th>
                                    <th scope="col">Dispatch Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">PDF</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Added By</th>
                                    <th scope="col">Entry Date</th>
                                </tr>
                            </thead>
                            @php
                                $mytime = Carbon\Carbon::now();
                                $todaytime = Carbon\Carbon::parse($mytime)->format('Y-m-d');
                            @endphp
                            <tbody>
                                @foreach ($dtofiledata as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-info text-white view-history-btn"
                                            style="padding: 2px 8px; font-size: 12px;"    
                                            data-id="{{ $items->id }}" data-reg="{{ $items->reg_number }}">
                                                <i class="bi bi-clock-history"></i> History
                                            </button>
                                        </td>

                                        <td>
                                            <a href="{{ url('admin/dto/edit-dto-file') }}/{{ $items->id }}"
                                                class="badge bg-primary">
                                                {{ strtoupper($items->reg_number) }}
                                            </a>
                                        </td>
                                        <td>{{ $items->rto_location }}</td>
                                        <td>{{ $items->vendor_name }}</td>
                                        <td>{{ $items->vendor_mobile_number }}</td>
                                        <td>{{ $items->dispatch_date }}</td>
                                        <td>
                                            @if ($items->dispatch_date != '')
                                                {{ Carbon\Carbon::parse($items->dispatch_date)->diffInDays($todaytime, true) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($items->status == 'Ready to Dispatch')
                                                <span class="badge bg-warning text-dark">{{ $items->status }}</span>
                                            @elseif($items->status == 'Dispatched')
                                                <span class="badge bg-info">{{ $items->status }}</span>
                                            @elseif($items->status == 'Online')
                                                <span class="badge bg-success">{{ $items->status }}</span>
                                            @elseif($items->status == 'Work Not Started')
                                                <span class="badge bg-danger">{{ $items->status }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $items->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ asset('files/') }}/{{ $items->upload_pdf }}"
                                                class="btn btn-sm btn-primary" download>
                                                <i class="bi bi-box-arrow-down"></i>
                                            </a>
                                        </td>
                                        <td>{{ $items->remarks }}</td>
                                        <td>{{ $items->created_by }}</td>
                                        <td>{{ date('d-M-Y', strtotime($items->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History for: <span id="modalRegNumber" class="fw-bold text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="historyTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20%">Date</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Archived File</th>
                                    <th style="width: 30%">Remarks</th>
                                    <th style="width: 20%">Updated By</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                            </tbody>
                        </table>
                    </div>
                    <div id="loadingSpinner" class="text-center my-3" style="display:none;">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        
        // 1. Initialize DataTable
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
            "pageLength": 50,
            "aaSorting": [[8, 'desc'], [7, 'desc']],
            scrollX: true
        });

        // 2. Handle History Button Click
        // Use 'body' delegate because DataTables might redraw rows, removing events
        $('body').on('click', '.view-history-btn', function() {
            var dtoId = $(this).data('id');
            var regNum = $(this).data('reg');

            // Set Title & Open Modal
            $('#modalRegNumber').text(regNum);
            $('#historyTableBody').html(''); // Clear previous data
            $('#loadingSpinner').show();     // Show Loader

            // Initialize and Show Modal
            var myModal = new bootstrap.Modal(document.getElementById('historyModal'));
            myModal.show();

            // 3. AJAX Request
            $.ajax({
                url: '{{ url("admin/dto/get-history") }}/' + dtoId,
                type: 'GET',
                success: function(response) {
                    $('#loadingSpinner').hide();
                    var rows = '';

                    if (response.length > 0) {
                        $.each(response, function(key, item) {

                            // --- LOGIC: File Download Button vs No Change Badge ---
                            var fileHtml = '';
                            if (item.file_url) {
                                fileHtml = `
                                    <a href="${item.file_url}" class="btn btn-sm btn-outline-danger" target="_blank" download>
                                        <i class="bi bi-file-earmark-pdf"></i> Download
                                    </a>`;
                            } else {
                                fileHtml = '<span class="badge bg-light text-secondary border">No File Change</span>';
                            }

                            // --- LOGIC: Status Badge Color ---
                            var badgeClass = 'bg-secondary';
                            if (item.status === 'Online') badgeClass = 'bg-success';
                            if (item.status === 'Dispatched') badgeClass = 'bg-info';
                            if (item.status === 'Hold') badgeClass = 'bg-danger';

                            // --- Build Table Row ---
                            rows += `
                                <tr>
                                    <td><small>${item.formatted_date}</small></td>
                                    <td><span class="badge ${badgeClass}">${item.status}</span></td>
                                    <td class="text-center">${fileHtml}</td>
                                    <td>${item.remarks}</td>
                                    <td><small>${item.created_by}</small></td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = '<tr><td colspan="5" class="text-center text-muted">No history found for this record.</td></tr>';
                    }

                    $('#historyTableBody').html(rows);
                },
                error: function() {
                    $('#loadingSpinner').hide();
                    $('#historyTableBody').html(
                        '<tr><td colspan="5" class="text-danger text-center">Error fetching data.</td></tr>'
                    );
                }
            });
        });
    });
</script>
@endsection
