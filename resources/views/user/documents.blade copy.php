@extends('user.layouts.app')
@section('container')

<!-- ***** Details Start ***** -->
<div class="document header-text">
    <div class="row">
      <div class="col-lg-12">
        <h2>Dokumen POBSI</h2>
      </div>
      <form action="/documents" method="GET">
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
                    <button type="submit">Cari Dokumen</button>
                  </div>
                  <div class="col-lg-12">
                      <div class="main-border-button text-center">
                          <a href="{{ url('/documents') }}">Dokumen (Tanpa Tag, Kategori, dan Penulis)</a>
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
                                        <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                                        <li><a href="{{ url('/documents?category=' . $d->document_categories->id) }}"><i class="fa fa-file"></i> {{ $d->document_categories->name }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <span><i class="fa fa-check"></i><a href="{{ url('/documents?author='. $d->user_posted_by->id) }}"> {{ $d->user_posted_by->user_data->name }} </a>| {{ $d->created_at }}</span>
                            <a href="{{ url('/document/'. $d->slug) }}">
                                <h4>{{ $d->title_summary }}</h4>
                                <p>{{ $d->excerpt }}</p>
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
                    <li><a href="{{ url('/documents?category='. $dc->id) }}">{{ $dc->name }} <span>{{ $dc->documents_count }}</span></a></li>
                @endforeach
            </ul>
            <div class="col-lg-12">
                <div class="main-button text-center mt-3">
                    <a href="{{ url('/document/document-categories') }}">Lihat Kategori Lainnya</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Banner End ***** -->

@endsection
