@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Slider Beranda</h3>
                <p class="text-subtitle text-muted">Ubah Data Slider Beranda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/home-sliders">Data Slider Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Slider Beranda</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if ($home_slider->home_slider_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$home_slider->home_slider_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <form action="{{ url('/admin/home-sliders/'.$home_slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="home_sliders_image_update">Foto Slider Beranda</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Foto Pengguna</div>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_home_sliders_image_update">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_title_update">Judul</label>
                        <input type="text" class="form-control" id="home_sliders_title_update" name="title" value="{{ old('title', $home_slider->title) }}" placeholder="Masukkan Nama">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_title_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_caption_update">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="home_sliders_caption_update" name="caption" value="{{ old('caption', $home_slider->caption) }}" placeholder="Masukkan Nama">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_caption_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_link_update">Tautan</label>
                        <input type="text" class="form-control" id="home_sliders_link_update" name="link" value="{{ old('link', $home_slider->link) }}" placeholder="Masukkan Nama">
                        @error('link')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_link_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="athleteagenda_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
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
                        @if ($home_slider->home_slider_images->image)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/'.$home_slider->home_slider_images->image) }}">
                            </div>
                        @else
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('assets/static/images/profile-image/default_profile_image.png') }}">
                            </div>
                        @endif
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
