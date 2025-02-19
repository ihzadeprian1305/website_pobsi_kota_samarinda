@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Dokumen</h3>
                <p class="text-subtitle text-muted">Lihat Data Dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/documents">Data Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Dokumen</h4>
            </div>
            <div class="card-body">
                @if ($document->document_cover_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                            <a href="#" class="thumbnail" data-bs-slide-to="1" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="w-100" src="{{ asset('storage/'. $document->document_cover_images->image) }}">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <div class="form-group">
                    <label for="documents_title_show">Judul</label>
                    <input type="text" class="form-control" name="title" id="documents_title_show" value="{{ $document->title }}" disabled>
                </div>
                <div class="form-group">
                    <label for="documents_slug_show">Judul</label>
                    <input type="text" class="form-control" name="slug" id="documents_slug_show" value="{{ $document->slug }}" disabled>
                </div>
                <div class="form-group">
                    <label for="documents_description_show">Deskripsi</label>
                    <textarea name="description" id="summernote">{{ $document->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="documents_document_categories_show">Kategori Dokumen</label>
                    <input type="text" class="form-control" name="name" id="documents_document_categories_show" value="{{ $document->document_categories->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="documents_user_posted_by_show">Diunggah Oleh</label>
                    <input type="text" class="form-control" name="name" id="documents_user_posted_by_show" value="{{ $document->user_posted_by->user_data->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="documents_user_posted_by_show">Dokumen</label>
                    @if (count($document->document_files) > 0)
                        @foreach ($document->document_files as $df)
                            <div class="list-group">
                                <a href="{{ Storage::url($df->file) }}" target="_blank" class="list-group-item list-group-item-action my-1">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $df->file_name }}</h5>
                                        <small>{{ $df->created_at }}</small>
                                    </div>
                                    <small>Klik Untuk Lihat atau Unduh</small>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-3">Dokumen Tidak Ditemukan</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Sampul Dokumen</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/'.$document->document_cover_images->image) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('[name="description"]').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
            code: `{!! $document->description !!}`
        }).summernote('disable');

        $('#summernote').next('.note-editor').find('.note-toolbar').hide();
    });
</script>
@endsection
