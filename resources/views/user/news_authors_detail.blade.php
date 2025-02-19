@extends('user.layouts.app')
@section('container')

<!-- ***** Details Start ***** -->
<div class="news header-text">
    <div class="row">
      <div class="col-lg-12">
        <h2>Berita POBSI</h2>
      </div>
      <form action="/news/news-authors" method="GET">
          <div class="col-lg-12">
            <div class="content">
              <div class="row">
                <div class="col-lg-12">
                    {{-- <i class="fa fa-search"></i> --}}
                    <input type="text" name="search" class="search" id="user-news-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
                </div>
                <div class="col-lg-12">
                  <div class="main-border-button">
                    <button type="submit">Cari Berita</button>
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
                <h4><em>Hasil Pencarian Berita dengan Penulis {{ $user->user_data->name }} :</em> {{ request('search') }}</h4>
            @else
                <h4><em>Berita POBSI dengan</em> Penulis {{ $user->user_data->name }}</h4>
            @endif
        </div>
    </div>
    <div class="row">
        @if(count($news) > 0)
            @foreach ($news as $n)
                <div class="col-lg-4 col-sm-12">
                    <div class="item">
                        <div class="thumb">
                            <img src="{{ asset('storage/'.$n->news_cover_images->image) }}" alt="">
                            <div class="hover-effect">
                                <div class="content">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                                        <li><a href="#"><i class="fa fa-file"></i> {{ $n->news_categories->name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <span><i class="fa fa-check"></i><a href="{{ url('/news/news-authors/'. $n->user_created_by->id) }}"> {{ $n->user_created_by->user_data->name }} </a> | {{ $n->created_at }}</span>
                            <a href="{{ url('/news/'. $n->slug) }}">
                                <h4>{{ $n->title_summary }}</h4>
                                <p>{{ $n->excerpt }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h4 class="text-center mb-3">Tidak Ada Berita</h4>
        @endif
    </div>
</div>
<!-- ***** Live Stream End ***** -->

@endsection
