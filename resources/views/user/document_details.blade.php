@extends('user.layouts.app')
@section('container')

<!-- ***** Details Start ***** -->
<div class="document header-text">
    <div class="row">
      <div class="col-lg-12">
        <h2>Dokumen<br>{{ $document_category->name }}</h2>
      </div>
      <form action="/documents/{{ $document_category->name }}" method="GET">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
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
                    <button type="submit">Cari Dokumen</button>
                  </div>
                  <div class="col-lg-12">
                      <div class="main-border-button text-center">
                          <a href="{{ url('/documents') }}">Dokumen (Tanpa Pencarian)</a>
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
                <h4><em>Dokumen POBSI dengan Kategori :</em> {{ $title_category->name }}</h4>
            @endif
            @if (isset($title_author))
                <h4><em>Dokumen POBSI dengan Perilis :</em> {{ $title_author->user_data->name }}</h4>
            @endif
            @if (request('search'))
                <h4><em>Hasil Pencarian :</em> {{ request('search') }}</h4>
            @endif
        </div>
    </div>
    <div class="row">
        @if(count($documents) > 0)
            @foreach ($documents as $d)
                <div class="col-lg-4 col-sm-12">
                    <div class="item">
                        <div class="thumb">
                            <img src="{{ asset('storage/'.$d->document_cover_images->image) }}" alt="">
                            <div class="hover-effect">
                                <div class="content">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-eye"></i> {{ $d->document_views()->count() }}</a></li>
                                        <li><a href="{{ url('/documents?category=' . $d->document_categories->id) }}"><i class="fa fa-file"></i> {{ $d->document_categories->name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <span><i class="fa fa-check"></i><a href="{{ url('/documents/'. $document_category->name .'?author='. $d->user_posted_by->id) }}"> {{ $d->user_posted_by->user_data->name }} </a>| {{ $d->created_at }}</span>
                            <a href="{{ url('/documents/'. $document_category->name . '/'. $d->slug) }}">
                                <h4>{{ $d->title_summary }}</h4>
                                <p>{{ $d->description_summary }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h4 class="text-center mb-3">Tidak Ada Dokumen</h4>
        @endif
        <div class="d-flex justify-content-center">
            {{ $documents->links() }}
        </div>
    </div>
</div>
<!-- ***** Live Stream End ***** -->

<!-- ***** Banner Start ***** -->
<div class="row">
    <div class="col-lg-12">
      <div class="main-profile ">
        <div class="row">
          <div class="col-lg-12">
            <div class="heading-section">
                <h4><em>Kategori</em></h4>
              </div>
            <ul>
                @foreach ($document_categories as $dc)
                    <li><a href="{{ url('/documents/'. $dc->name) }}">{{ $dc->name }} <span>{{ $dc->documents_count }}</span></a></li>
                @endforeach
            </ul>
            <div class="col-lg-12">
                <div class="main-button text-center mt-3">
                    <a href="{{ url('/documents') }}">Lihat Kategori Lainnya</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Banner End ***** -->

@endsection
