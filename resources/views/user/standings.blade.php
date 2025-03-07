@extends('user.layouts.app')
@section('container')
<!-- ***** Gaming Library Start ***** -->
<div class="standing header-text">
    <div class="col-lg-12">
        <div class="heading-section">
        <h4><em>Peringkat Handicap</em> Atlet POBSI Kota Samarinda</h4>
        </div>
        @foreach ($standings as $s)
        <div class="item">
            <ul>
                <li><h4>{{ $loop->iteration }}</h4></li>
                <li><img src="{{ asset('storage/' . $s->athletes->athlete_images->image) }}" alt="" class="img-standing"></li>
                <li><h4>{{ $s->athletes->name }}</h4></li>
                <li><h4>Handicap</h4><span>{{ $s->handicaps->name }}</span></li>
                <li><h4>Poin</h4><span>{{ $s->total_points }}</span></li>
            </ul>
        </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $standings->links() }}
        </div>
    </div>
</div>
<!-- ***** Gaming Library End ***** -->
@endsection
