@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="athlete header-text">
    <div class="col-lg-12">
        <div class="heading-section">
            <h4><em>Galeri Gambar</em> {{ $image_gallery->title }}</h4>
        </div>
        <h6 class="mb-3">{{ $image_gallery->caption }}</h6>
        <div class="grid">
            @foreach ($image_gallery_images as $igi)
            <div class="grid-item">
                <a data-fancybox="gallery" data-src="{{ asset('storage/' . $igi->image) }}">
                    <img src="{{ asset('storage/' . $igi->image) }}" alt="" />
                </a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $image_gallery_images->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
