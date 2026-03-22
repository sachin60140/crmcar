@extends('admin.layouts.app')

@section('title', 'View Lead Data | Car 4 Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <style>
        .badge { cursor: pointer; }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">View Branch</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Branch</h5>

                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Cloud Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emplist as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->branch ?? 'N/A' }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->emp_mobile }}</td>
                                        <td>{{ $items->cloud_calling_number }}</td>
                                        <td>{{ $items->email }}</td>
                                        <td>
                                            @if($items->user_type == 1)
                                                <span class="badge bg-dark">Admin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($items->status == 1)
                                                <button type="button" class="btn btn-success btn-sm status-toggle" 
                                                    data-id="{{ $items->id }}" data-name="{{ $items->name }}" data-action="Deactivate">
                                                    Active
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm status-toggle" 
                                                    data-id="{{ $items->id }}" data-name="{{ $items->name }}" data-action="Activate">
                                                    Deactivated
                                                </button>
                                            @endif

                                            {{-- Hidden Form for Security --}}
                                            <form id="status-form-{{ $items->id }}" action="{{ url('admin/employee/toggle-status', $items->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{url('admin/edit-employee')}}/{{ $items->id }}" class="badge bg-primary"> Update </a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                pageLength: 50,
                order: [
                        [7, 'asc'],  // 1st Priority: Group by Status first
                        [6, 'asc'],  // 2nd Priority: Then group by User Type
                        [0, 'desc']  // 3rd Priority: Finally, sort by ID descending within those groups
                        ]
            });

            // SweetAlert Status Toggle
            $('.status-toggle').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const action = $(this).data('action');
                const color = action === 'Deactivate' ? '#d33' : '#28a745';

                Swal.fire({
                    title: 'Confirm Status Change',
                    text: `Are you sure you want to ${action} ${name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: color,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Yes, ${action}!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('status-form-' + id).submit();
                    }
                });
            });

            // Success Message Toast
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endsection