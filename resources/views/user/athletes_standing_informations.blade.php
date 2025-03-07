@extends('user.layouts.app')
@section('container')


<div class="main-profile header-text">
    <div class="row">
        <div class="most-popular">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section">
                        <h4><em>Pilih Handicap</em> Atlet POBSI Kota Samarinda</h4>
                    </div>
                    <div class="row">
                        @foreach ($handicaps as $h)
                            <div class="col-lg-3 col-sm-12">
                                <a href="{{ url('/athlete-informations/standings/'.$h->name) }}">
                                    <div class="item" class="text-center">
                                        <h3 class="text-center">{{ $h->name }}</h4>
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
@endsection
