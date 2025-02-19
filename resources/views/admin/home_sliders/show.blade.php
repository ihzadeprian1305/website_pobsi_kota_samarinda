@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Slider Beranda</h3>
                <p class="text-subtitle text-muted">Lihat Data Slider Beranda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/home-sliders">Data Slider Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Slider Beranda</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($home_slider->home_slider_images->image)
                        <div class="row gallery">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$home_slider->home_slider_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-center mb-3">Gambar Tidak Ditemukan</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="home_sliders_title_show">Judul</label>
                    <input type="text" class="form-control" name="title" id="home_sliders_title_show" value="{{ $home_slider->title }}" disabled>
                </div>
                <div class="form-group">
                    <label for="home_sliders_caption_show">Penjelasan Singkat</label>
                    <input type="text" class="form-control" name="home_sliders_caption" id="home_sliders_caption_show" value="{{ $home_slider->caption }}" disabled>
                </div>
                <div class="form-group">
                    <label for="home_sliders_link_show">Tautan</label>
                    <input type="text" class="form-control" name="name" id="home_sliders_link_show" value="{{ $home_slider->link }}" disabled>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Slider Beranda</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/'.$home_slider->home_slider_images->image) }}">
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
@endsection
