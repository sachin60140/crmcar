@extends('admin.layouts.app')

@section('title', 'Just Dail Data | Car 4 Sales')


@section('style')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<meta name="viewport" content="width=device-width" />


@endsection

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Just Dail Data</li>
                
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Just Dail Data </h5>
                        {{-- <h5 class="card-title"><a href="{{url("admin/employee/generate-pdf")}}" target="_blank" > click me to pdf </a></h5> --}}

                        <!-- Table with stripped rows -->
                        <table class="table display" style="font-size: 13px;" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Lead ID</th>
                                    <th scope="col">Lead Type</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">City</th>
                                    <th scope="col">area</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">DND Mobile</th>
                                    <th scope="col">DND Phone</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Pincode</th>
                                    <th scope="col">Branch Pin</th>
                                    <th scope="col">Parent ID</th>
                                    <th scope="col">Craeted at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($just_dail_data as $items)
                                    <tr>
                                        <td>{{ $items->id }}</td>
                                        <td>{{ $items->leadid }}</td>
                                        <td>{{ $items->leadtype }}</td>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->mobile }}</td>
                                        <td>{{ $items->phone }}</td>
                                        <td>{{ $items->email }}</td>
                                        <td>{{ $items->date }}</td>
                                        <td>{{ $items->time }}</td>
                                        <td>{{ $items->category }}</td>
                                        <td>{{ $items->city }}</td>
                                        <td>{{ $items->area }}</td>
                                        <td>{{ $items->brancharea }}</td>
                                        <td>
                                            @if ( $items->dncmobile == 0)
                                                <button class="btn btn-danger btn-sm">DND</button>
                                            @endif
                                        <td>
                                            @if ( $items->dncphone == 0)
                                                <button class="btn btn-danger btn-sm">DND</button>
                                            @endif
                                        </td>
                                        <td>{{ $items->company }}</td>
                                        <td>{{ $items->pincode }}</td>
                                        <td>{{ $items->branchpin }}</td>
                                        <td>{{ $items->parentid }}</td>
                                        <td>{{ $items->created_at }}</td>
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
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
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
