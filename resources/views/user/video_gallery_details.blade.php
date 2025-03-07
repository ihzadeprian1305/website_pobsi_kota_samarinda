@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="athlete header-text">
    <div class="col-lg-12">
        <div class="heading-section">
            <h4><em>Galeri Gambar</em> {{ $video_gallery->title }}</h4>
        </div>
        <h6 class="mb-3">{{ $video_gallery->caption }}</h6>
        <div class="grid">
            @foreach ($video_gallery_videos as $v)
            <div class="grid-item">
                <a data-fancybox="gallery" data-src="{{ asset('storage/' . $v->video) }}" data-caption="<div class='text-center'><h5>{{ $v->title }}</h4><p>{{ $v->caption }}</p></div>">
                    <img src="{{ asset('storage/' . $v->video_gallery_video_images[0]->image) }}" alt="" />
                </a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $video_gallery_videos->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
