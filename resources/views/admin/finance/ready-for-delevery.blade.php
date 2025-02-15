@extends('admin.layouts.app')

@section('title', 'Ready for Delivary file Status | Car 4 Sales')


@section('style')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">View Ready for Delivary file Status</li>
                
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div>
            @if ($errors->any())
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Ready for Delivary file Status</h5>
                        {{-- <h5 class="card-title"><a href="{{url("admin/employee/generate-pdf")}}" target="_blank" > click me to pdf </a></h5> --}}

                        <!-- Table with stripped rows -->
                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                   
                                    <th scope="col">Registration</th>
                                    <th scope="col">RTO</th>
                                    <th scope="col">Financer</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col">Booking</th>
                                    <th scope="col">Funding</th>
                                    <th scope="col">Updated on</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewfinancefiledetails as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->cutomer_name }}</td>
                                       
                                        
                                        <td>{{ $items->reg_number }}</td>
                                        <td>{{ $items->rto_name }}</td>
                                        <td>{{ $items->financer_name }}</td>
                                        <td>{{ $items->finance_file_status }}</td>
                                        <td>{{ $items->sold_amount }}</td>
                                        <td>{{ $items->booking_amount }}</td>
                                        <td>{{ $items->finance_amount }}</td>
                                        <td>
                                            @php
                                                $last_update_status = DB::table('finance_remarks')
                                                                    ->where('finace_file_id','=' , $items->id)
                                                                    ->latest('created_at')
                                                                    ->first();
                                                echo $last_update_status->created_at;
                                            @endphp
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/finance-file-edit/' . $items->id) }}"
                                                class="link-primary">Update</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/finance-file-view/' . $items->id) }}"
                                                class="link-primary">Status</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

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
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    "pageLength": 50,

                    "aaSorting": [
                        [0, 'desc']
                    ],
                });
            });
        </script>
    @endsection
