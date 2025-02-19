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
                    <h4><em>Pengurus Utama</em> POBSI Kota Samarinda</h4>
                  </div>
                </div>
                <div class="row justify-content-center">
                    @foreach ($structure_ketua_umum as $sku)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $sku->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $sku->name }}</h4>
                                    <h5>{{ $sku->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                    @foreach ($structure_ketua_harian as $skh)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $skh->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $skh->name }}</h4>
                                    <h5>{{ $skh->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                    @foreach ($structure_sekretaris_and_bendahara as $ssab)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $ssab->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $ssab->name }}</h4>
                                    <h5>{{ $ssab->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                    @foreach ($structure_ketua_kompartemen as $skk)
                        <div class="col-lg-4 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{ asset('storage/' . $skk->structure_images->image) }}" alt="" style="border-radius: 23px;">
                                </div>
                                <div class="down-content">
                                    <h4>{{ $skk->name }}</h4>
                                    <h5>{{ $skk->structure_positions->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="main-profile">
        <div class="row">
          <div class="col-lg-12">
            <div class="clips">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-section">
                    <h4><em>Bidang</em> POBSI Kota Samarinda</h4>
                  </div>
                </div>
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
                                <div class="col-lg-12">
                                  <div class="structures main-button">
                                    <a href="{{ url('/structures/member-field-structures/' . $skb->structure_positions->structure_fields->id) }}">Lihat Anggota</a>
                                  </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
