@extends('user.layouts.app')
@section('container')

<div class="row">
    <div class="col-lg-12">
      <div class="main-profile header-text">
        <div class="row">
            <div class="most-popular">
              <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                        <a href="{{ url('/galleries/image-galleries') }}">
                            <div class="item">
                                <img src="{{ asset('assets/static/images/gallery-menu-image/image-menu-image.jpg') }}" alt="">
                                <h4>Gambar<br><span>Lihat Semua Galeri Gambar POBSI Kota Samarinda</span></h4>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                        <a href="{{ url('/galleries/video-galleries') }}">
                            <div class="item">
                                <img src="{{ asset('assets/static/images/gallery-menu-image/video-menu-image.jpg') }}" alt="">
                                <h4>Video<br><span>Lihat Semua Galeri Video POBSI Kota Samarinda</span></h4>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
