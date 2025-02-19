@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Foto</h3>
                <p class="text-subtitle text-muted">Tambah Data Galeri Foto</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/image-galleries">Data Galeri Foto</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Galeri Foto</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/image-galleries') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image_galleries_title_create">Judul</label>
                        <input type="text" class="form-control" id="image_galleries_title_create" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_title_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_galleries_caption_create">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="image_galleries_caption_create" name="caption" value="{{ old('caption') }}" placeholder="Masukkan Penjelasan Singkat">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_caption_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_galleries_image_create">Gambar</label>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="image_galleries_image_create" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_image_galleries_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
