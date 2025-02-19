@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Slider Beranda</h3>
                <p class="text-subtitle text-muted">Tambah Data Slider Beranda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/home-sliders">Data Slider Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Slider Beranda</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/home-sliders') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="home_sliders_image_create">Foto Slider Beranda</label>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_home_sliders_image_create">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_title_create">Judul</label>
                        <input type="text" class="form-control" id="home_sliders_title_create" name="title" value="{{ old('title') }}" placeholder="Masukkan Nama">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_title_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_caption_create">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="home_sliders_caption_create" name="caption" value="{{ old('caption') }}" placeholder="Masukkan Penjelasan Singkat">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sliders_caption_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="home_sliders_link_create">Tautan</label>
                        <input type="text" class="form-control" id="home_sliders_link_create" name="link" value="{{ old('link') }}" placeholder="Masukkan Tautan">
                        @error('link')
                            <div class="text-danger mt-2" role="alert" id="alert_home_sllink_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_home_sliders_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
