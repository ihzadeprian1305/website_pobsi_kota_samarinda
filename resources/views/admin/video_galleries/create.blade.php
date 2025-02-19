@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Video</h3>
                <p class="text-subtitle text-muted">Tambah Data Galeri Video</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/video-galleries">Data Galeri Video</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Galeri Video</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/video-galleries') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="video_galleries_title_create">Judul</label>
                        <input type="text" class="form-control" id="video_galleries_title_create" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_title_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="video_galleries_caption_create">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="video_galleries_caption_create" name="caption" value="{{ old('caption') }}" placeholder="Masukkan Penjelasan Singkat">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_caption_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="video_galleries_video_create">Video</label>
                        <input type="file" class="multiple-files-filepond" name="video[]" id="video_galleries_video_create" multiple>
                        @error('video')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_video_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_video_galleries_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
