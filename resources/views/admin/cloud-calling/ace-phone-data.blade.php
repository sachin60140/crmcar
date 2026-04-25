@extends('admin.layouts.app')

@section('title', 'Cloud Call Data | Car 4 Sales')

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
    .table-sm-text { font-size: 13px; width: 100% !important; }
    .filter-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 20px;
    }
    .card-box {
        padding:15px;
        border-radius:8px;
        color:#fff;
    }
</style>
@endsection

@section('content')

<div class="container-fluid">

    <!-- ================= SUMMARY ================= -->
    <div class="row mb-3">

        <div class="col-md-3">
            <div class="card-box bg-primary">
                <h6>Total Calls</h6>
                <h4>{{ $totalCalls }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-success">
                <h6>Answered</h6>
                <h4>{{ $answered }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-danger">
                <h6>Missed</h6>
                <h4>{{ $missed }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box bg-dark">
                <h6>Conversion</h6>
                <h4>{{ $conversionRate }}%</h4>
            </div>
        </div>

    </div>

    <!-- ================= FILTER ================= -->
    <form method="GET" class="filter-box row g-3">

        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control"
                value="{{ request('from_date', $from->format('Y-m-d')) }}">
        </div>

        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control"
                value="{{ request('to_date', $to->format('Y-m-d')) }}">
        </div>

        <div class="col-md-2">
            <select name="call_status" class="form-control">
                <option value="">All Status</option>
                <option value="answered" {{ request('call_status')=='answered'?'selected':'' }}>Answered</option>
                <option value="missed" {{ request('call_status')=='missed'?'selected':'' }}>Missed</option>
            </select>
        </div>

        <div class="col-md-2">
            <select name="agent" class="form-control">
                <option value="">All Agent</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent }}" {{ request('agent')==$agent?'selected':'' }}>
                        {{ $agent }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="campaign" class="form-control">
                <option value="">All Campaign</option>
                @foreach($campaigns as $c)
                    <option value="{{ $c }}" {{ request('campaign')==$c?'selected':'' }}>
                        {{ $c }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>

    <!-- ================= TABLE ================= -->
    <table id="callTable" class="display table-sm-text table table-bordered table-striped nowrap">

        <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Caller</th>
            <th>Receiver</th>
            <th>Type</th>
            <th>Status</th>
            <th>Duration</th>
            <th>Agent</th>
            <th>Campaign</th>
            <th>Recording</th>
        </tr>
        </thead>

        <tbody>

        @foreach($calls as $call)
        <tr>
            <td></td>
            <td>{{ $call->start_stamp }}</td>

            <td>{{ $call->caller_id_number }}</td>

            <td>{{ $call->call_to_number }}</td>

            <td>
                <span class="badge bg-info">
                    {{ $call->direction }}
                </span>
            </td>

            <td>
                <span class="badge 
                    @if($call->call_status=='answered') bg-success 
                    @elseif($call->call_status=='missed') bg-danger 
                    @else bg-secondary @endif">
                    {{ $call->call_status }}
                </span>
            </td>

            <td>{{ $call->duration }} sec</td>

            <td>{{ $call->answered_agent_name }}</td>

            <td>{{ $call->campaign_name }}</td>

            <td>
                @if($call->recording_url)
                    <a href="{{ $call->recording_url }}" target="_blank" class="btn btn-sm btn-warning">
                        🎧
                    </a>
                @else
                    -
                @endif
            </td>

        </tr>
        @endforeach

        </tbody>

    </table>

</div>

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<!-- REQUIRED FOR EXCEL -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {

    // ==============================
    // DATE FOR FILE NAME
    // ==============================
    var fromDate = "{{ request('from_date', $from->format('Y-m-d')) }}";
    var toDate   = "{{ request('to_date', $to->format('Y-m-d')) }}";

    // ==============================
    // INIT DATATABLE
    // ==============================
    var table = $('#callTable').DataTable({
        responsive: true,
        pageLength: 50,
        dom: 'Bfrtip',

        buttons: [

            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            },

            {
                extend: 'csv',
                filename: 'Call_Report_' + fromDate + '_to_' + toDate,
                exportOptions: {
                    columns: ':visible',
                    modifier: { search: 'applied' },
                    format: {
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            },

            {
                extend: 'excel',
                filename: 'Call_Report_' + fromDate + '_to_' + toDate,
                title: 'Call Report',
                exportOptions: {
                    columns: ':visible',
                    modifier: { search: 'applied' },
                    format: {
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            },

            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: function (data, row, column) {
                            if (column === 0) return row + 1;
                            return $('<div>').html(data).text().trim();
                        }
                    }
                }
            }

        ],

        order: [[1, 'desc']],

        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false
            }
        ]
    });

    // ==============================
    // SL NUMBER (TABLE UI)
    // ==============================
    function updateSL() {
        var info = table.page.info();

        table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    }

    // First load
    updateSL();

    // On redraw (pagination/search/sort)
    table.on('draw.dt', function () {
        updateSL();
    });

});
</script>

@endsection