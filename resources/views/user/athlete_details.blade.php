@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="athlete-detail header-text">
    <div class="col-lg-12">
        <div class="heading-section">
            <h4><em>Detail</em> Atlet</h4>
        </div>
        @if($athlete->athlete_images)
        <div class="athlete-detail-item">
            <div class="thumb text-center">
                <img src="{{ asset('storage/'. $athlete->athlete_images->image) }}" alt="">
            </div>
        </div>
        @else
            <h4 class="text-center mb-3">Tidak Ada Foto Atlet</h4>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="athlete-detail-content mt-3">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h4>Nama</h4>
                            <h6 class="mt-1">{{ $athlete->name }}</h6>
                            <h4 class="mt-3">Jenis Kelamin</h4>
                            <h6 class="mt-1 mb-3">{{ $athlete->sex }}</h6>
                            <h4 class="mt-3">Tanggal Lahir</h4>
                            <h6 class="mt-1 mb-3">{{ $athlete->born_date }}</h6>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h4>Tim</h4>
                            <h6 class="mt-1">{{ $athlete->pool_houses->name ?? $athlete->another_pool_house }}</h6>
                            <h4 class="mt-3">Handicap</h4>
                            <h6 class="mt-1 mb-3">{{ $athlete->standings->handicaps->name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            @if($athlete->career_description)
            <div class="col-12">
                <div class="athlete-detail-content mt-3">
                    <h3>Deskripsi</h3>
                    <div class="row">
                        <div class="col-12">
                            <p>{!! $athlete->career_description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
