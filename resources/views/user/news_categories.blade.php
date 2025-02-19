@extends('user.layouts.app')
@section('container')

<!-- ***** Details Start ***** -->
<div class="news header-text">
    <div class="row">
      <div class="col-lg-12">
        <h2>Berita POBSI</h2>
      </div>
      <form action="/news/news-categories" method="GET">
      <div class="col-lg-12">
        <div class="content">
          <div class="row">
            <div class="col-lg-12">
                {{-- <i class="fa fa-search"></i> --}}
                <input type="text" name="search" class="search" id="user-news-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
            </div>
            <div class="col-lg-12">
              <div class="main-border-button">
                <button type="submit">Cari Kategori</button>
              </div>
            </div>
          </div>
        </div>
      </div>
  </form>
    </div>
  </div>
  <!-- ***** Details End ***** -->

<!-- ***** Live Stream Start ***** -->
<div class="live-stream mb-5">
    <div class="col-lg-12">
        <div class="heading-section">
            @if (request('search'))
                <h4><em>Hasil Pencarian :</em> {{ request('search') }}</h4>
            @else
                <h4><em>Kategori Berita</em> POBSI</h4>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          <div class="main-profile">
            <div class="row">
              <div class="col-lg-12">
                <ul>
                    @foreach ($news_categories as $nc)
                        <li><a href="{{ url('/news?category='. $nc->id) }}">{{ $nc->name }} <span>{{ $nc->news_count }}</span></a></li>
                    @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- ***** Live Stream End ***** -->

@endsection
