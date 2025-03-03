@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="pool-house-detail header-text">
    <div class="col-lg-12">
        <div class="heading-section">
            <h4><em>Detail</em> {{ $poolHouse->name }}</h4>
        </div>
        @if(count($poolHouse->pool_house_images) > 0)
            <div class="owl-pool-houses owl-carousel">
                @foreach ($poolHouse->pool_house_images as $phi)
                <div class="pool-house-detail-item">
                    <div class="thumb">
                        <img src="{{ asset('storage/'.$phi->image) }}" alt="">
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <h4 class="text-center mb-3">Tidak Ada Foto Sarana Olahraga</h4>
        @endif
        <div class="pool-house-detail-map-container mt-3">
            {!! html_entity_decode($poolHouse->link_address) !!}
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pool-house-detail-content mt-3">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h4>Pemilik</h4>
                            <h6 class="mt-1">{{ $poolHouse->owner_name }}</h6>
                            <h4 class="mt-3">Nomor Handphone</h4>
                            <h6 class="mt-1 mb-3">{{ $poolHouse->phone_number }}</h6>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h4>Jam Buka</h4>
                            <h6 class="mt-1">{{ $poolHouse->open_time }} WITA</h6>
                            <h4 class="mt-3">Jam Tutup</h4>
                            <h6 class="mt-1 mb-3">{{ $poolHouse->close_time }} WITA</h6>
                        </div>
                        <div class="col-12">
                            <h4>Alamat</h4>
                            <h6>{!! $poolHouse->address !!}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="pool-house-detail-content mt-3">
                    <h3>Deskripsi</h3>
                    <div class="row">
                        <div class="col-12">
                            <p>{!! $poolHouse->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
