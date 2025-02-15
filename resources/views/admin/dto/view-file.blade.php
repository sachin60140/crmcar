@extends('admin.layouts.app')

@section('title', 'View DTO File | Car 4 Sales')


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
                <li class="breadcrumb-item">View DTO FIle</li>
                
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
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
                <div class="card">
                    <div class="card-body" >
                        <h5 class="card-title">View Dto File  </h5>
                        
                       

                        <!-- Table with stripped rows -->
                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Registation</th>
                                    <th scope="col">RTO</th>
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Vendor Mobile</th>
                                    <th scope="col">Dispatch Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">PDF</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Added By</th>
                                    <th scope="col">Updated By</th>
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
                                            <a href="{{url('admin/dto/edit-dto-file')}}/{{ $items->id }}" class="badge bg-primary"> {{ $items->reg_number}}</a>
                                           
                                        </td>
                                        <td>{{ $items->rto_location }}</td>
                                        <td>{{ $items->vendor_name }}</td>
                                        <td>{{ $items->vendor_mobile_number }}</td>
                                        <td>{{ $items->dispatch_date }}</td>
                                        <td>
                                            @if ($items->dispatch_date != "")
                                           
                                                {{ Carbon\Carbon::parse($items->dispatch_date)->diffInDays($todaytime, true) }}
                                            
                                            @endif
                                            
                                        </td>
                                        <td>{{ $items->status }}</td>
                                        <td>
                                            <a href="{{asset('files/')}}/{{$items->upload_pdf}}" class="btn btn-sm btn-primary" download>
                                            <i class="bi bi-box-arrow-down"></i>
                                            </a>
                                        </td>
                                        <td>{{ $items->remarks }}</td>
                                        <td>{{ $items->created_by }}</td>
                                        <td>{{ $items->created_at }}</td>
                                        
                                        <td>{{date('d-M-Y', strtotime($items->created_at))}}</td>
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
                    columnDefs: [{ width: 25, targets: 0 }],
                        fixedColumns: true,
                        paging: true,
                        scrollCollapse: true,
                        scrollX: true,
                        
                    
                });
            });
        </script>
    @endsection
