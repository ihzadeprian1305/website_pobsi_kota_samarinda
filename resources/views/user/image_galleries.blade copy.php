@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->

<div class="athlete header-text">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Galeri Gambar</em> POBSI Kota Samarinda</h4>
        </div>
        <div class="grid">
            @foreach ($images as $i)
            <div class="grid-item">
                <img src="{{ asset('storage/' . $i->image_gallery_images->image) }}" alt="">
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->

@endsection
