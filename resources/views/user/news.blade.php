@extends('user.layouts.app')
@section('container')

<!-- ***** Details Start ***** -->
<div class="news header-text">
    <div class="row">
      <div class="col-lg-12">
        <h2>Berita POBSI</h2>
      </div>
      <form action="/news" method="GET">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('tag'))
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            @endif
            @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
          <div class="col-lg-12">
            <div class="content">
              <div class="row">
                <div class="col-lg-12">
                    {{-- <i class="fa fa-search"></i> --}}
                    <input type="text" name="search" class="search" id="user-news-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
                </div>
                <div class="col-lg-12 mb-1">
                  <div class="main-border-button">
                    <button type="submit">Cari Berita</button>
                  </div>
                  <div class="col-lg-12">
                      <div class="main-border-button text-center">
                          <a href="{{ url('/news') }}">Berita (Tanpa Pencarian)</a>
                      </div>
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
            @if (isset($title_category))
                <h4><em>Berita POBSI dengan Kategori :</em> {{ $title_category->name }}</h4>
            @endif
            @if (isset($title_tag))
                <h4><em>Berita POBSI dengan Tag :</em> {{ $title_tag->name }}</h4>
            @endif
            @if (isset($title_author))
                <h4><em>Berita POBSI dengan Penulis :</em> {{ $title_author->user_data->name }}</h4>
            @endif
            @if (request('search'))
                <h4><em>Hasil Pencarian :</em> {{ request('search') }}</h4>
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
                                        <li><a href="#"><i class="fa fa-eye"></i> {{ $n->news_views()->count() }}</a></li>
                                        <li><a href="{{ url('/news?category=' . $n->news_categories->id) }}"><i class="fa fa-file"></i> {{ $n->news_categories->name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <span><i class="fa fa-check"></i><a href="{{ url('/news?author='. $n->user_created_by->id) }}"> {{ $n->user_created_by->user_data->name }} </a>| {{ $n->created_at }}</span>
                            <a href="{{ url('/news/news-details/'. $n->slug) }}">
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
        <div class="d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
</div>
<!-- ***** Live Stream End ***** -->

<!-- ***** Banner Start ***** -->
<div class="row">
    <div class="col-lg-12">
      <div class="main-profile ">
        <div class="row">
          <div class="col-lg-6">
            <div class="heading-section">
                <h4><em>Kategori</em></h4>
              </div>
            <ul>
                @foreach ($news_categories as $nc)
                    <li><a href="{{ url('/news?category='. $nc->id) }}">{{ $nc->name }} <span>{{ $nc->news_count }}</span></a></li>
                @endforeach
            </ul>
            <div class="col-lg-12">
                <div class="main-button text-center mt-3">
                    <a href="{{ url('/news/news-categories') }}">Lihat Kategori Lainnya</a>
                </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="heading-section">
                <h4><em>Tag</em></h4>
              </div>
            <ul>
                @foreach ($news_tags as $nt)
                    <li><a href="{{ url('/news?tag='. $nt->id) }}">{{ $nt->name }} <span>{{ $nt->news_count }}</span></a></li>
                @endforeach
            </ul>
            <div class="col-lg-12">
                <div class="main-button text-center mt-3">
                    <a href="{{ url('/news/news-tags') }}">Lihat Tag Lainnya</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Banner End ***** -->

@endsection
