@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="athlete header-text">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Atlet</em> POBSI Kota Samarinda</h4>
        </div>
        @foreach ($athletes as $a)
        <div class="item">
            <ul>
                <li><img src="{{ asset('storage/' . $a->athlete_images->image) }}" alt="" class="img-athlete"></li>
                <li><h4>{{ $a->name }}</h4></li>
                <li><h4>Tim</h4><san>{{ $a->pool_houses->name ?? $a->another_pool_house }}</san></li>
                <li><h4>Handicap</h4><san>{{ $a->standings->handicaps->name }}</san></li>
                <li><div class="main-border-button"><a href="{{ url('/athlete-informations/athletes/' . $a->name) }}">Lihat</a></div></li>
            </ul>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $athletes->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
