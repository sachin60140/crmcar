@extends('admin.layouts.app')

@section('title', 'View Online DTO File | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Table Layout Fixes */
        #example {
            width: 100% !important;
            table-layout: auto;
            /* Allows browser to adjust, but we control via min-width */
        }

        /* Header Styling - Prevent Wrapping */
        .table thead th {
            background-color: #f1f4f9;
            color: #333;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
            /* Forces header text to stay on one line */
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
        }

        /* Data Cells */
        .table tbody td {
            font-size: 0.85rem;
            vertical-align: middle;
            white-space: nowrap;
            /* Default to one line */
        }

        /* Allow Remarks to Wrap but control width */
        .remarks-col {
            white-space: normal !important;
            min-width: 200px;
            max-width: 300px;
            font-size: 0.8rem;
            line-height: 1.2;
        }

        /* Filter Card */
        .filter-card {
            background: #f8f9fa;
            border-left: 4px solid #0d6efd;
            margin-bottom: 20px;
        }

        /* Scrollbar */
        .dataTables_scrollBody::-webkit-scrollbar {
            height: 10px;
        }

        .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">View Online DTO File</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">

        <div class="card filter-card">
            <div class="card-body py-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Search Filters</h6>
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Online Date (From)</label>
                        <input type="text" id="min_date" class="form-control form-control-sm date-filter"
                            placeholder="YYYY-MM-DD">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Online Date (To)</label>
                        <input type="text" id="max_date" class="form-control form-control-sm date-filter"
                            placeholder="YYYY-MM-DD">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Quick Search</label>
                        <input type="text" id="global_search" class="form-control form-control-sm"
                            placeholder="Type Reg No, Vendor...">
                    </div>
                    <div class="col-md-3 text-end">
                        <button id="reset_filters" class="btn btn-sm btn-outline-secondary w-100">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body pt-3">

                <table class="table table-hover table-bordered table-striped align-middle" id="example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Registration</th>
                            <th>RTO</th>
                            <th>Vendor</th>
                            <th>Mobile</th>
                            <th>Dispatch Date</th>
                            <th>Online Date</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th class="text-center">Files</th>
                            <th>Remarks</th>
                            <th>Updated By</th>
                            <th>Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dtofiledata as $items)
                            <tr>
                                <td>{{ $items->id }}</td>
                                <td class="fw-bold text-primary">{{ $items->reg_number }}</td>
                                <td>{{ $items->rto_location }}</td>
                                <td>{{ $items->vendor_name }}</td>
                                <td>{{ $items->vendor_mobile_number }}</td>
                                <td>{{ $items->dispatch_date }}</td>
                                <td>{{ $items->online_date }}</td>

                                <td class="text-center">
                                    @if ($items->dispatch_date && $items->online_date)
                                        @php $days = Carbon\Carbon::parse($items->dispatch_date)->diffInDays($items->online_date); @endphp
                                        <span
                                            class="badge {{ $days > 90 ? 'bg-danger' : 'bg-success' }}">{{ $days }}</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <span class="badge {{ $items->status == 'Online' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $items->status }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        @if ($items->upload_pdf)
                                            <a href="{{ asset('files/' . $items->upload_pdf) }}"
                                                class="btn btn-outline-danger btn-sm" title="PDF" download>
                                                <i class="bi bi-file-pdf"></i>
                                            </a>
                                        @endif
                                        @if ($items->upload_mparivahan)
                                            <a href="{{ asset('files/' . $items->upload_mparivahan) }}"
                                                class="btn btn-outline-success btn-sm" title="Img" download>
                                                <i class="bi bi-card-image"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <td class="remarks-col">{{ $items->remarks }}</td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $items->updated_by }}</span>
                                        <small
                                            class="text-muted">{{ date('d-M-y', strtotime($items->updated_at)) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $items->created_by }}</span>
                                        <small
                                            class="text-muted">{{ date('d-M-y', strtotime($items->created_at)) }}</small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $(".date-filter").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });

            var table = $('#example').DataTable({
                dom: 'Brtip',
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-success btn-sm me-1',
                        text: '<i class="bi bi-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        text: '<i class="bi bi-file-pdf"></i> PDF',
                        orientation: 'landscape',
                    }
                ],
                pageLength: 50,
                scrollX: true,
                autoWidth: false, // Important: allows columnDefs to work
                order: [
                    [6, 'desc']
                ],

                // DEFINE SPECIFIC WIDTHS HERE
                columnDefs: [{
                        width: "30px",
                        targets: 0
                    }, // ID
                    {
                        width: "120px",
                        targets: 1
                    }, // Reg No
                    {
                        width: "100px",
                        targets: 6
                    }, // Online Date
                    {
                        width: "80px",
                        targets: 9
                    }, // Files
                    {
                        width: "250px",
                        targets: 10
                    } // Remarks (Wider)
                ]
            });

            // Date Search Logic
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var min = $('#min_date').val();
                var max = $('#max_date').val();
                var dateCol = data[6]; // Index 6 = Online Date
                if (min === "" && max === "") return true;
                if (min === "" && dateCol <= max) return true;
                if (max === "" && dateCol >= min) return true;
                if (dateCol >= min && dateCol <= max) return true;
                return false;
            });

            $('#min_date, #max_date').change(function() {
                table.draw();
            });
            $('#global_search').keyup(function() {
                table.search(this.value).draw();
            });
            $('#reset_filters').click(function() {
                $('.date-filter').val('');
                $('#global_search').val('');
                table.search('').draw();
            });
        });
    </script>
@endsection
