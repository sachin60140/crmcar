@extends('admin.layouts.app')

@section('title', 'Cloud Call Data | Car 4 Sales')

@section('style')
    {{-- 1. DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        /* Compact table text */
        .table-sm-text {
            font-size: 13px;
            width: 100% !important;
        }
        /* Filter Box Styling */
        .filter-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Cloud Call Data</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cloud Call Data</h5>

                        {{-- DATE FILTER SECTION --}}
                        <div class="filter-box">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="filterBtn" class="btn btn-primary">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                    <button type="button" id="resetBtn" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- END FILTER SECTION --}}

                        {{-- TABLE (Empty Body) --}}
                        <table class="table display table-sm-text" id="qkonnectTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Call Type</th>
                                    <th>Caller</th>
                                    <th>Call Time</th>
                                    <th>End Time</th>
                                    <th>Total Duration</th>
                                    <th>Agent</th>
                                    <th>Recording</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data is loaded here via AJAX --}}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- 1. jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- 2. DataTables Core --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- 3. Export Dependencies (Excel/PDF) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    {{-- 4. Buttons --}}
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    {{-- <script>
        $(document).ready(function() {

            // Dynamic Filename
            var today = new Date().toISOString().slice(0, 10);
            var exportTitle = 'Qkonnect_Call_Data_' + today;

            // Initialize DataTable
            var table = $('#qkonnectTable').DataTable({
                processing: true,  // Show "Processing..." loader
                serverSide: true,  // Enable Server-side processing
                responsive: true,
                pageLength: 50,
                
                // AJAX Setup
                ajax: {
                    url: "{{ url()->current() }}", // Points to your showqkonnectdata route
                    data: function (d) {
                        // Send date inputs to the server
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },

                // Column Mapping (Must match Database columns)
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'Call_type', name: 'Call_type'},
                    {data: 'caller_number', name: 'caller_number'},
                    {data: 'call_start_time', name: 'call_start_time'},
                    {data: 'call_end_time', name: 'call_end_time'},
                    {data: 'total_call_time', name: 'total_call_time'},
                    {data: 'agent_number', name: 'agent_number'},
                    {data: 'call_recording', name: 'call_recording', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                ],

                // Order by 'Created At' (Column Index 8) descending
                order: [[8, 'desc']], 

                // Layout & Buttons
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    { extend: 'excel', title: exportTitle },
                    { extend: 'csv', title: exportTitle },
                    { extend: 'pdf', title: exportTitle, orientation: 'landscape' }
                ]
            });

            // Filter Button Logic
            $('#filterBtn').click(function(){
                table.draw(); // Refreshes table with new Date parameters
            });

            // Reset Button Logic
            $('#resetBtn').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                table.draw(); // Refreshes table (back to default 15 days)
            });

        });
    </script> --}}
<script>
    $(document).ready(function() {

        // 1. Define a function to generate the dynamic name
        function getExportFileName() {
            
            // Helper function to convert YYYY-MM-DD to DD-MM-YYYY
            function formatDate(dateStr) {
                if (!dateStr) return '';
                var parts = dateStr.split('-'); // Split 2025-12-14
                return parts[2] + '-' + parts[1] + '-' + parts[0]; // Return 14-12-2025
            }

            var start = $('#start_date').val();
            var end = $('#end_date').val();
            
            // Get Today's Date in YYYY-MM-DD format first
            var todayRaw = new Date().toISOString().slice(0, 10);

            if (start && end) {
                // Returns: Qkonnect_Call_Data_01-10-2023_to_15-10-2023
                return 'Qkonnect_Call_Data_' + formatDate(start) + '_to_' + formatDate(end);
            } else {
                // Returns: Qkonnect_Call_Data_14-12-2025
                return 'Qkonnect_Call_Data_' + formatDate(todayRaw);
            }
        }

        // Initialize DataTable
        var table = $('#qkonnectTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                    [50, 100, 250, -1], 
                    [50, 100, 250, "All"]
                ],
            pageLength: 50,

            // AJAX Setup
            ajax: {
                url: "{{ url()->current() }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },

            // Column Mapping
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'Call_type', name: 'Call_type' },
                { data: 'caller_number', name: 'caller_number' },
                { data: 'call_start_time', name: 'call_start_time' },
                { data: 'call_end_time', name: 'call_end_time' },
                { data: 'total_call_time', name: 'total_call_time' },
                { data: 'agent_number', name: 'agent_number' },
                { data: 'call_recording', name: 'call_recording', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
            ],

            order: [[8, 'desc']],
            

            dom: 'lBfrtip',
            
            // 2. Updated Buttons Configuration
            buttons: [
                'copy',
                { 
                    extend: 'excel', 
                    title: getExportFileName, 
                    filename: getExportFileName 
                },
                { 
                    extend: 'csv', 
                    title: getExportFileName, 
                    filename: getExportFileName 
                },
                { 
                    extend: 'pdf', 
                    title: getExportFileName, 
                    filename: getExportFileName, 
                    orientation: 'landscape' 
                }
            ]
        });

        // Filter Button Logic
        $('#filterBtn').click(function() {
            table.draw();
        });

        // Reset Button Logic
        $('#resetBtn').click(function() {
            $('#start_date').val('');
            $('#end_date').val('');
            table.draw();
        });

    });
</script>


@endsection