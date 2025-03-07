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
                        @foreach ($images as $i)
                        <div class="col-lg-3 col-sm-12">
                            <a href="{{ url('/galleries/image-galleries/' . $i->id) }}">
                                <div class="item">
                                    <img src="{{ asset('storage/' . $i->image_gallery_images[0]->image) }}" alt="">
                                    <h4>{{ $i->title }}<br><span>{{ $i->caption }}</span></h4>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
