@extends('user.layouts.app')
@section('container')

<div class="row">
    <div class="col-lg-12">
      <div class="main-profile header-text">
        <div class="row">
          <div class="col-lg-12">
            <div class="clips">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-section">
                    <h4>{{ $structure_field }}</h4>
                  </div>
                </div>
                @if (count($structure_kepala_bidang) > 0 && count($structure_anggota_bidang) > 0)
                <div class="row justify-content-center">
                    @foreach ($structure_kepala_bidang as $skb)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $skb->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $skb->name }}</h4>
                                    <h5>{{ $skb->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                    @foreach ($structure_anggota_bidang as $sab)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $sab->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $sab->name }}</h4>
                                    <h5>{{ $sab->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <h5 class="text-center mb-3">Tidak Ada Anggota</h5>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
