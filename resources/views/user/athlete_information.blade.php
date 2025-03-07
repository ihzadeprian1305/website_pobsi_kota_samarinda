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
                        <a href="{{ url('/athlete-informations/athletes') }}">
                            <div class="item">
                                <img src="{{ asset('assets/static/images/athlete-menu-image/athlete-menu-image.png') }}" alt="">
                                <h4>Atlet<br><span>Lihat Semua Atlet POBSI Kota Samarinda</span></h4>
                            </div>
                        </a>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                        <a href="{{ url('/athlete-informations/standing_informations') }}">
                            <div class="item">
                                <img src="{{ asset('assets/static/images/athlete-menu-image/handicap-menu-image.png') }}" alt="">
                                <h4>Handicap<br><span>Lihat Handicap Atlet POBSI Kota Samarinda</span></h4>
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
