@extends('employee.layouts.app')

@section('title', 'Visit Lead Data | Car 4 Sales')


@section('style')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


@endsection

@section('content')
    <div class="pagetitle">
        <h1>Employee Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employee/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">View lead</li>
                <li class="breadcrumb-item">Visit Follow Up lead</li>
                
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
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
                        <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                            role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Calling Follow Up lead </h5>
                       
                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Lead Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Mobile</th>
                                    
                                    <th scope="col">Last Updated</th>
                                    <th scope="col">Follow Up date</th>
                                    <th scope="col">Update</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calling_lead as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->Name }}</td>
                                        <td>{{ $items->lead_type }}</td>
                                        <td>{{ $items->calling_status }}</td>
                                        <td>{{ $items->mobile_number }}</td>
                                       
                                        <td>
                                            @php
                                                $last_update_status = DB::table('customer_lead_remarks')
                                                                    ->where('cust_lead_id','=' , $items->id)
                                                                    ->latest('updated_at')
                                                                    ->first();
                                                echo $last_update_status->updated_at;
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                            $last_update_status = DB::table('customer_lead_remarks')
                                                                ->where('cust_lead_id','=' , $items->id)
                                                                ->latest('next_folloup_date')
                                                                ->first();
                                            echo date('d-M-Y', strtotime($last_update_status->next_folloup_date));
                                            
                                        @endphp
                                        </td>
                                       
                                        <td>
                                            <a href="{{ url('employee/data/update-lead/' . $items->id) }}"
                                                class="link-primary">Update</a>
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
                        [6, 'desc']
                    ],
                });
            });
        </script>
    @endsection
