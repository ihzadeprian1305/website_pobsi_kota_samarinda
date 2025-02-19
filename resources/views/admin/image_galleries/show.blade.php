@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Foto</h3>
                <p class="text-subtitle text-muted">Lihat Data Galeri Foto</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/image-galleries">Data Galeri Foto</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Galeri Foto</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="image_galleries_title_show">Judul</label>
                    <input type="text" class="form-control" name="title" id="image_galleries_title_show" value="{{ $imageGallery->title }}" disabled>
                </div>
                <div class="form-group">
                    <label for="image_galleries_caption_show">Penjelasan Singkat</label>
                    <input type="text" class="form-control" name="image_galleries_caption" id="image_galleries_caption_show" value="{{ $imageGallery->caption }}" disabled>
                </div>
                @if (count($imageGallery->image_gallery_images) > 0)
                    <div class="row gallery">
                        @foreach($imageGallery->image_gallery_images as $igi)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                    <img class="w-100" src="{{ asset('storage/'.$igi->image) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Galeri Foto</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($imageGallery->image_gallery_images as $index => $igi)
                            <button
                                type="button"
                                data-bs-target="#Gallerycarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($imageGallery->image_gallery_images as $index => $igi)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset('storage/'.$igi->image) }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#Gallerycarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#Gallerycarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
