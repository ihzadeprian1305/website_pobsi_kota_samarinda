@extends('user.layouts.app')
@section('container')
<!-- ***** Details Start ***** -->
<div class="news-detail header-text">
<div class="row">
    {{-- <div class="col-lg-12">
    <h2>Detail Berita</h2>
    </div> --}}
    <div class="col-lg-8">
        <div class="content">
            <div class="row">
            <div class="col-lg-12">
                <img src="{{ asset('storage/' . $news->news_cover_images->image) }}" class="object-fit-cover" alt="" style="border-radius: 23px; margin-bottom: 30px;">
            </div>
            <div class="col-lg-12">
                <div class="heading-section">
                    <h4>{{ $news->title }}</h4>
                </div>
            </div>
            <div class="col-lg-12">
                    <div class="right-info">
                      <ul>
                        <li><a href="{{ url('/news?author='. $news->user_created_by->id) }}"><i class="fa fa-user"></i> {{ $news->user_created_by->user_data->name }}</a></li>
                        <li><a href="{{ url('/news?category=' . $news->news_categories->id) }}"><i class="fa fa-folder"></i> {{ $news->news_categories->name }}</a></li>
                        <li><i class="fa fa-calendar"></i> {{ $news->created_at }}</li>
                        <li><i class="fa fa-eye"></i> {{ $news->news_views()->count() }}</li>
                      </ul>
                    </div>
              </div>
            <div class="col-lg-12">
                {!! $news->content !!}
            </div>
            {{-- <div class="col-lg-12">
                <div class="main-border-button">
                <a href="#">Download Fortnite Now!</a>
                </div>
            </div> --}}
            @if (count($news->news_images) > 0)
                @foreach ($news->news_images as $nni)
                <div class="col-lg-4">
                    <img src="{{ asset('storage/' .$nni->image) }}" class="object-fit-cover" alt="" style="border-radius: 23px; margin-bottom: 30px;">
                </div>
                @endforeach
            @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="news-detail-column-search">
          <div class="heading-section">
            <h4><em>Pencarian</em> Berita</h4>
          </div>
          <form action="/news" action="GET">
              <div class="col-lg-12">
                {{-- <i class="fa fa-search"></i> --}}
                <input type="text" name="search" class="search" id="user-news-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
            </div>
          </form>
        </div>
        <div class="news-detail-column-popular">
            <div class="heading-section">
              <h4><em>Berita</em> Terbaru</h4>
            </div>
            @if (count($all_news) > 0)
            <ul>
                @foreach ($all_news as $nan)
                <li>
                    <a href="{{ url('/news/news-details/'. $nan->slug) }}">
                        <img src="{{ asset('storage/'. $nan->news_cover_images->image) }}" alt="" class="image">
                        <h3>{{ $nan->title_summary }}</h3>
                        <h6>{{ $nan->excerpt }}</h6>
                        <span><i class="fa fa-user" style="color: #fefd02;"></i> {{ $nan->user_created_by->user_data->name }}</span>
                        <span><i class="fa fa-calendar" style="color: #bf0223;"></i> {{ $nan->created_at }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
                <h5 class="text-center mb-3">Tidak Ada Berita</h5>
            @endif
            <div class="text-button">
              <a href="{{ url('/news') }}">Lihat Semua Berita</a>
            </div>
          </div>
          <div class="news-detail-column-category">
            <div class="heading-section">
                <h4>Kategori</h4>
            </div>
            <div class="col-12 align-self-center">
                <ul>
                    @foreach ($news_categories as $nc)
                        <li><a href="{{ url('/news?category='. $nc->id) }}">{{ $nc->name }} <span>{{ $nc->news_count }}</span></a></li>
                    @endforeach
                </ul>
            </div>
          </div>
          <div class="news-detail-column-tag">
            <div class="heading-section">
                <h4>Tag</h4>
                <div class="col-12 align-self-center">
                    <ul>
                        @foreach ($news_tags as $nt)
                            <li><a href="{{ url('/news?tag='. $nt->id) }}">{{ $nt->name }} <span>{{ $nt->news_count }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
              </div>
          </div>
      </div>
</div>
</div>
<!-- ***** Details End ***** -->

{{-- <!-- ***** Other Start ***** -->
<div class="other-games">
<div class="row">
    <div class="col-lg-12">
    <div class="heading-section">
        <h4><em>Other Related</em> Games</h4>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-01.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-02.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-03.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-02.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-03.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="item">
        <img src="assets/images/game-01.jpg" alt="" class="templatemo-item">
        <h4>Dota 2</h4><span>Sandbox</span>
        <ul>
        <li><i class="fa fa-star"></i> 4.8</li>
        <li><i class="fa fa-download"></i> 2.3M</li>
        </ul>
    </div>
    </div>
</div>
</div>
<!-- ***** Other End ***** --> --}}
@endsection
