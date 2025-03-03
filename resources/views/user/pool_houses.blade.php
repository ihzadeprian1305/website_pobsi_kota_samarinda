@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="pool-house header-text">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Temukan</em> Sarana Olahraga</h4>
        </div>
        @foreach ($pool_houses as $pa)
        <div class="item">
            <ul>
                <li><img src="{{ asset('storage/' . $pa->pool_house_images[0]->image) }}" alt="" class="img-pool-house"></li>
                <li><h4>{{ $pa->name }}</h4></li>
                <li><h4>Jam Buka</h4><span>{{ $pa->open_time }}</span></li>
                <li><h4>Jam Tutup</h4><span>{{ $pa->close_time }}</span></li>
                <li><div class="main-border-button"><a href="{{ url('/pool-houses/' . $pa->name) }}">Lihat</a></div></li>
            </ul>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $pool_houses->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
