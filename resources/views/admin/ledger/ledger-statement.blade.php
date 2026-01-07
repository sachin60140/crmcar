@extends('admin.layouts.app')

@section('title', 'View Ledger | Car 4 Sales')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        table.dataTable tbody td {
            padding: 8px 12px;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    @php
        $customerName = $getRecords->first()->name ?? 'Customer Statement';
    @endphp

    <div class="pagetitle">
        <h1>Client Statement</h1>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">
                            Statement : {{ $customerName }}
                        </h5>

                        <div class="table-responsive">
                            <table class="table display" id="ledgerTable" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Txn Date</th>
                                        <th>Entry Date</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-end">Balance</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($getRecords as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->particular }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->txn_date)->format('d-M-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-M-Y') }}</td>

                                            <td class="text-end">
                                                {{ number_format($row->amount, 2) }}
                                            </td>

                                            <td class="text-end fw-bold">
                                                {{ number_format($row->running_balance, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

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

    <script>
        $(document).ready(function() {

            let customerName = @json($customerName);

            $('#ledgerTable').DataTable({
                dom: 'Bfrtip',
                ordering: false,
                pageLength: 50,

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'Statement : ' + customerName,
                        messageTop: 'Customer Ledger Statement'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Statement - ' + customerName
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Statement - ' + customerName,
                        orientation: 'portrait',
                        pageSize: 'A4'
                    }
                ]
            });

        });
    </script>
@endsection
