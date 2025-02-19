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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.709160865345!2d117.11364538715821!3d-0.4817461999999868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67fbc175afa69%3A0xb3e54cb8f53996b9!2sMARKAS%20BILLIARD%20SAMARINDA!5e0!3m2!1sid!2sid!4v1739330406223!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
