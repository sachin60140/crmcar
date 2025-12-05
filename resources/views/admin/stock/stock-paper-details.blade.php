@extends('admin.layouts.app')

@section('title', 'View Inspection Report | Car 4 Sale')


@section('style')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.bootstrap5.min.css" rel="stylesheet">
    <style>
        tr.dtrg-group td {
            background-color: #e3f2fd !important;
            font-weight: bold;
            color: #0d47a1;
            border-top: 2px solid #90caf9;
        }

        /* Hide the default DataTables search box since we are making a custom one */
        div.dataTables_filter {
            display: none;
        }
    </style>

@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item active">DTO</li>
                <li class="breadcrumb-item active">View Stock Details</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="container-fluid bg-white p-4 shadow-sm rounded">

            <div class="row mb-4 align-items-end">
                <div class="col-md-6">
                    <h3 class="text-primary mb-0"><i class="bi bi-car-front-fill"></i> Vehicle Documents</h3>
                </div>
                <div class="col-md-6">
                    <label for="vehicleSearch" class="form-label fw-bold text-secondary">Search Vehicle Number:</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="vehicleSearch" class="form-control form-control-lg"
                            placeholder="Type Vehicle Number (e.g. BR01...)">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">Clear</button>
                    </div>
                </div>
            </div>

            <table id="docTable" class="table table-hover table-bordered" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Vehicle Number</th>
                        <th style="width: 20%;">Document Type</th>
                        <th style="width: 80%;">Attachments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row['vehicle_number'] }}</td>
                            <td><span class="fw-bold text-secondary">{{ $row['document_type'] }}</span></td>
                            <td>{!! $row['attachments'] !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content" style="height: 90vh;">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">File Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0 d-flex align-items-center justify-content-center bg-dark">
                        <div id="modalContent" class="text-white">Loading...</div>
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="#" id="downloadLink" class="btn btn-success" download>Download</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>

<script>
    $(document).ready(function() {
        
        // 1. Initialize DataTable
        var table = $('#docTable').DataTable({
            ordering: false, 
            columnDefs: [
                { visible: false, targets: 0 } // Hide Vehicle Number Column
            ],
            rowGroup: {
                dataSrc: 0,
                startRender: function (rows, group) {
                    return $('<tr>').append('<td colspan="2" class="bg-light">' + 
                        '<i class="bi bi-truck me-2"></i><strong>' + group + '</strong>' + 
                        '</td>');
                }
            },
            paging: true,
            pageLength: 50,
            dom: 'rtip' // Hide default search box ('f' is removed from dom)
        });

        // 2. Custom Search Logic (Vehicle Number ONLY)
        $('#vehicleSearch').on('keyup', function() {
            // column(0) refers to the Vehicle Number column
            table.column(0).search(this.value).draw();
        });

        // 3. Clear Search Button
        $('#clearSearch').on('click', function() {
            $('#vehicleSearch').val('');
            table.column(0).search('').draw();
        });

        // 4. Preview Modal Logic (Same as before)
        $(document).on('click', '.btn-preview', function() {
            var fileUrl = $(this).data('file-url');
            var fileType = $(this).data('file-type');
            var htmlContent = '';

            if(['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileType)) {
                htmlContent = '<img src="' + fileUrl + '" style="max-height: 100%; max-width: 100%; object-fit: contain;">';
            } else if (fileType === 'pdf') {
               // htmlContent = '<iframe src="' + fileUrl + '" style="width: 100%; height: 100%; border: none;"></iframe>';
                htmlContent = '<iframe src="https://docs.google.com/gview?url=' + encodeURIComponent(fileUrl) + '&embedded=true" style="width:100%; height:100%; border:none;"></iframe>';
            } else {
                htmlContent = '<div class="text-white">Cannot preview. Please download.</div>';
            }

            $('#modalContent').html(htmlContent);
            $('#downloadLink').attr('href', fileUrl);
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        });
        
        $('#previewModal').on('hidden.bs.modal', function () {
            $('#modalContent').html('');
        });
    });
</script>
@endsection
