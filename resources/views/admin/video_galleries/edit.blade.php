@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Video</h3>
                <p class="text-subtitle text-muted">Ubah Data Galeri Video</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/video-galleries">Data Galeri Video</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Galeri Video</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/video-galleries/'.$videoGallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="video_galleries_title_update">Judul</label>
                        <input type="text" class="form-control" id="video_galleries_title_update" name="title" value="{{ old('title', $videoGallery->title) }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_title_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="video_galleries_caption_update">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="video_galleries_caption_update" name="caption" value="{{ old('caption', $videoGallery->caption) }}" placeholder="Masukkan Penjelasan Singkat">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_caption_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="video_galleries_video_update">Video</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Menambah Video | Masukkan Jika Ingin Menambah Video | Wajib Menambahkan Video Jika Tidak Terdapat Video Sama Sekali</div>
                        <input type="file" class="multiple-files-filepond" name="video[]" id="video_galleries_video_update" multiple>
                        @error('video')
                            <div class="text-danger mt-2" role="alert" id="alert_video_galleries_video_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="video_gallery_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Hapus Video Galeri Video</h4>
            </div>
            <div class="card-body">
                @if (count($videoGallery->video_gallery_videos) > 0)
                    <div class="row gallery">
                        @foreach($videoGallery->video_gallery_videos as $vgv)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <video class="rounded col-12" controls>
                                    <source src="{{ asset('storage/'.$vgv->video) }}" id="video_galleries_video_show" class="mx-auto d-block rounded img-fluid mb-3 col-sm-5" type="video/mp4">
                                </video>
                                <form action="{{ url('/admin/video-galleries/'. $vgv->id . '/delete-video') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mt-1 d-flex mx-auto" type="submit">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">Video Tidak Ditemukan</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
