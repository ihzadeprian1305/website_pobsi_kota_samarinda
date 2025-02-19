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
          <div class="col-lg-12">
            <div class="content">
              <div class="row">
                <div class="col-lg-12">
                    {{-- <i class="fa fa-search"></i> --}}
                    <input type="text" name="search" class="search" id="user-news-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
                </div>
                <div class="col-lg-12 mb-1">
                  <div class="main-border-button">
                    <button type="submit">Cari Kategori Dokumen</button>
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
<div class="document">
    <div class="col-lg-12">
        <div class="heading-section">
            @if (request('search'))
                <h4><em>Hasil Pencarian :</em> {{ request('search') }}</h4>
            @endif
        </div>
    </div>
    <div class="row">
        @if(count($document_categories) > 0)
            @foreach ($document_categories as $dc)
                <div class="col-lg-3 col-sm-6">
                    <a href="{{ url('/documents/'. $dc->name) }}">
                        <div class="item h-100">
                            <img src="assets/static/images/default-image/document-cover-image.png" class="rounded-3" alt="">
                            <h4>{{ $dc->name }}</h4>
                            <h6>{{ $dc->documents_count }} Dokumen</h6>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <h4 class="text-center mb-3">Tidak Ada Kategori Dokumen</h4>
        @endif
        <div class="d-flex justify-content-center">
            {{ $document_categories->links() }}
        </div>
    </div>
</div>
<!-- ***** Live Stream End ***** -->

@endsection
