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
                        @foreach ($videos as $v)
                        <div class="col-lg-3 col-sm-12">
                            <a href="{{ url('/galleries/video-galleries/' . $v->id) }}">
                                <div class="item">
                                    <img src="{{ asset('storage/' . $v->video_gallery_videos[0]->video_gallery_video_images[0]->image) }}" alt="">
                                    <h4>{{ $v->title }}<br><span>{{ $v->caption }}</span></h4>
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
