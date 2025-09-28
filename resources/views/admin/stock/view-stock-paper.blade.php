@extends('admin.layouts.app')

@section('title', 'View Inspection Report | Car 4 Sale')


@section('style')

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
            <li class="breadcrumb-item active">Workshop</li>
            <li class="breadcrumb-item active">View Inspection</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section dashboard">

    <div class="container mt-5">
        <h1 class="mb-4 text-center">📄 Stock Paper Download</h1>

        <form action="#" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search by Vehicle Reg Number..." value="{{ $query ?? '' }}"
                >
                <button class="btn btn-primary" type="submit">Search</button>
                <a href="{{ route('viewstockpaper') }}" class="btn btn-secondary">🔄 Reset</a>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                Search Results
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Reg No.</th>
                            <th>Doc Type</th>
                            
                            <th>Uploaded At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->Reg_no }}</td>
                                <td>{{ $file->doc_type }}</td>
                                
                                <td>{{ $file->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('files.download', $file->id) }}" class="btn btn-success btn-sm">
                                        ⬇️ Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No files found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($files->hasPages())
                <div class="card-footer">
                    {{ $files->appends(['query' => $query])->links() }}
                </div>
            @endif
        </div>
    </div>
    @endsection

    @section('script')
    @endsection