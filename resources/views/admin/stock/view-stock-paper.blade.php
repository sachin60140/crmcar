@extends('admin.layouts.app')

@section('title', 'View Inspection Report | Car 4 Sale')


@section('style')

    <style>
        /* Add this for your thumbnail and iframe */
        .file-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 3px;
        }

        #pdf-preview-iframe {
            width: 100%;
            height: 75vh;
        }

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
    </div>
    <section class="section dashboard">

        <div class="container mt-5">
            <h1 class="mb-4 text-center">📄 Stock Paper Download</h1>

            <form action="#" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Search by Vehicle Reg Number..."
                        value="{{ $query ?? '' }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <a href="{{ route('viewstockpaper') }}" class="btn btn-secondary">🔄 Reset</a>
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    Search Results
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Reg No.</th>
                                <th>Preview</th>
                                <th>Doc Type</th>
                                <th>Added By</th>

                                <th>Uploaded At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($files as $file)
                                @php
                                    // Get the file extension for checking
                                    $extension = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));

                                    // ✨ FIX: Use asset() to generate a public URL
                                    $fileUrl = asset('uploads/stock_papers/' . $file->file_name);

                                @endphp
                                <tr>
                                    <td>{{ $file->id }}</td>
                                    <td>{{ $file->Reg_no }}</td>
                                    <td>
                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
                                            <img src="{{ $fileUrl }}" alt="{{ $file->file_name }}"
                                                class="file-thumbnail" data-bs-toggle="modal"
                                                data-bs-target="#imagePreviewModal" data-url="{{ $fileUrl }}">
                                        @elseif ($extension == 'pdf')
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#pdfPreviewModal" data-url="{{ $fileUrl }}">
                                                PDF 👁️
                                            </button>
                                        @else
                                            <span class="text-muted">No Preview</span>
                                        @endif
                                    </td>
                                    <td>{{ $file->doc_type }}</td>
                                    <td>{{ $file->created_by }}</td>

                                    <td>{{ $file->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('files.download', $file->id) }}" class="btn btn-success btn-sm">
                                            ⬇️ Download
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">No files found.</td>
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

        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="" id="image-preview-element" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfPreviewModalLabel">PDF Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="" id="pdf-preview-iframe" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- This bootstrap script might already be in your app.blade.php layout. If so, you can remove it. --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Image Modal 
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            if (imagePreviewModal) {
                imagePreviewModal.addEventListener('show.bs.modal', function(event) {
                    const triggerElement = event.relatedTarget; // Element that triggered the modal
                    const fileUrl = triggerElement.getAttribute('data-url');
                    const modalImage = imagePreviewModal.querySelector('#image-preview-element');
                    modalImage.setAttribute('src', fileUrl);
                });
            }

            // Handle PDF Modal
            const pdfPreviewModal = document.getElementById('pdfPreviewModal');
            if (pdfPreviewModal) {
                pdfPreviewModal.addEventListener('show.bs.modal', function(event) {
                    const triggerElement = event.relatedTarget; // Element that triggered the modal
                    const fileUrl = triggerElement.getAttribute('data-url');
                    const modalIframe = pdfPreviewModal.querySelector('#pdf-preview-iframe');
                    modalIframe.setAttribute('src', fileUrl);
                });
            }
        });
    </script>
@endsection
