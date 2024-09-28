@extends('admin.layouts.app')

@section('title', 'View Finance file Status | Car 4 Sales')


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
                <li class="breadcrumb-item">View Finance file Status</li>
                
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
        @php
            foreach ($customer_details as $item) {
                $name = $item->cutomer_name;
                $mobile = $item->mobile;
                $cutomer_pan = $item->cutomer_pan;
                $aadhar = $item->aadhar;
                $address = $item->address;
                $reg_number = $item->reg_number;
                $rto_name = $item->rto_name;
                $booking_amount = $item->booking_amount;
                $finance_amount = $item->finance_amount;
                $created_by = $item->created_by;
                $created_at = $item->created_at;
                $updated_at = $item->updated_at;
                $financer_name = $item->financer_name;
                $file_status_type = $item->file_status_type;
            }
        @endphp
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Finance file Status </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Name of Cusotmer: <span><strong>{{ $name}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Mobile: <span><strong>{{ $mobile}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Pan: <span><strong>{{ $cutomer_pan}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Aadhar: <span><strong>{{ $aadhar}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Address: <span><strong>{{ $address}}</strong></span></label>
                            </div>
                           
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Registration: <span><strong>{{ $reg_number}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">RTO: <span><strong>{{ $rto_name}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Booking Amount: <span><strong>{{ $booking_amount}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Finance Amount: <span><strong>{{ $finance_amount}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Entry Done by: <span><strong>{{ $created_by}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Created Date: <span><strong>{{ $created_at}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Last Update on: <span><strong>{{ $updated_at}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Financer: <span><strong>{{ $financer_name}}</strong></span></label>
                            </div>
                            <div class="col-md-4">
                                <label for="fee" class="form-label">Current File Status: <span><strong>{{ $file_status_type}}</strong></span></label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Remarks Status </h5>
                        <div class="row">
                            <div class="col">
                               <table class="table">
                                <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Remarks</th>
                                      <th scope="col">Date</th>
                                      <th scope="col">Entry by</th>
                                      
                                    </tr>
                                  </thead>
                                    <tbody>
                                        @foreach ($remarks as $remark_stage )
                                            <tr>
                                                <td>{{$remark_stage->id}}</td>
                                                <td>{{$remark_stage->remarks}}</td>
                                                <td>{{$remark_stage->created_at}}</td>
                                                <td>{{$remark_stage->created_by}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                               </table>
                            </div>
                        </div>

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
