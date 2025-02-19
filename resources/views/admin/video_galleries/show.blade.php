@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Video</h3>
                <p class="text-subtitle text-muted">Lihat Data Galeri Video</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/video-galleries">Data Galeri Video</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Galeri Video</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="video_galleries_title_show">Judul</label>
                    <input type="text" class="form-control" name="title" id="video_galleries_title_show" value="{{ $videoGallery->title }}" disabled>
                </div>
                <div class="form-group">
                    <label for="video_galleries_caption_show">Penjelasan Singkat</label>
                    <input type="text" class="form-control" name="video_galleries_caption" id="video_galleries_caption_show" value="{{ $videoGallery->caption }}" disabled>
                </div>
                <div class="form-group">
                    <label for="video_galleries_video_show">Video</label>
                    @if (count($videoGallery->video_gallery_videos) > 0)
                        <div class="row gallery">
                            @foreach($videoGallery->video_gallery_videos as $vgv)
                                <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                    <video class="rounded col-12" controls>
                                        <source src="{{ asset('storage/'.$vgv->video) }}" id="video_galleries_video_show" class="mx-auto d-block rounded img-fluid mb-3 col-sm-5" type="video/mp4">
                                    </video>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Video Tidak Ditemukan</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
