@extends('user.layouts.app')
@section('container')
<!-- ***** Details Start ***** -->
<div class="document-detail header-text">
<div class="row">
    {{-- <div class="col-lg-12">
    <h2>Detail Dokumen</h2>
    </div> --}}
    <div class="col-lg-8">
        <div class="content">
            <div class="row">
            <div class="col-lg-12">
                <img src="{{ asset('storage/' . $document->document_cover_images->image) }}" class="object-fit-cover" alt="" style="border-radius: 23px; margin-bottom: 30px;">
            </div>
            <div class="col-lg-12">
                <div class="heading-section">
                    <h4>{{ $document->title }}</h4>
                </div>
            </div>
            <div class="col-lg-12">
                    <div class="right-info">
                      <ul>
                        <li><a href="{{ url('/documents?author='. $document->user_posted_by->id) }}"><i class="fa fa-user"></i> {{ $document->user_posted_by->user_data->name }}</a></li>
                        <li><a href="{{ url('/documents?category=' . $document->document_categories->id) }}"><i class="fa fa-folder"></i> {{ $document->document_categories->name }}</a></li>
                        <li><i class="fa fa-calendar"></i> {{ $document->created_at }}</li>
                        <li><i class="fa fa-eye"></i> {{ $document->document_views()->count() }}</li>
                      </ul>
                    </div>
              </div>
            <div class="col-lg-12">
                {!! $document->description !!}
            </div>
            {{-- <div class="col-lg-12">
                <div class="main-border-button">
                <a href="#">Download Fortnite Now!</a>
                </div>
            </div> --}}
            @if (count($document->document_files) > 0)
            <!-- ***** Gaming Library Start ***** -->
            {{-- <div class="document-category-detail-file document-detail-file">
                <div class="col-lg-12 col-12">
                    @foreach ($document->document_files as $ddf)
                    <div class="item">
                        <ul>
                            <li><h4>{{ $ddf->file_name }}</h4></li>
                            <li><h4>Dirilis Pada</h4><span>{{ $ddf->created_at }}</span></li>
                            <li><h4>Dirilis Oleh</h4><span>{{ $document->user_posted_by->user_data->name }}</span></li>
                            <li><div class="main-border-button border-no-active"><a href="{{ Storage::url($ddf->file) }}" target="_blank">Lihat atau Unduh</a></div></li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div> --}}
        <div class="document-category-detail-file document-detail-file">
            <div class="col-lg-12 col-12">
                @foreach ($document->document_files as $ddf)
                <div class="item row align-items-center">
                    <div class="col-lg-8 col-md-8 col-12 file-name">
                        <h4>{{ $ddf->file_name }}</h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-right download-btn">
                        <div class="main-border-button">
                            <a href="{{ Storage::url($ddf->file) }}" download>Lihat atau Unduh</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        <!-- ***** Gaming Library End ***** -->
            @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="document-detail-column-search">
          <div class="heading-section">
            <h4><em>Pencarian</em> Dokumen</h4>
          </div>
          <form action="/documents" action="GET">
              <div class="col-lg-12">
                {{-- <i class="fa fa-search"></i> --}}
                <input type="text" name="search" class="search" id="user-document-search" value="{{ request('search') }}" placeholder="Masukkan Kata Pencarian">
            </div>
          </form>
        </div>
        <div class="document-detail-column-popular">
            <div class="heading-section">
              <h4><em>Pengumuman</em> Terbaru</h4>
            </div>
            @if (count($all_announcement_documents) > 0)
            <ul>
                @foreach ($all_announcement_documents as $and)
                <li>
                    <a href="{{ url('/documents/document-details/'. $and->slug) }}">
                        <img src="{{ asset('storage/'. $and->document_cover_images->image) }}" alt="" class="image">
                        <h3>{{ $and->title_summary }}</h3>
                        <h6>{{ $and->description_summary }}</h6>
                        <span><i class="fa fa-user" style="color: #fefd02;"></i> {{ $and->user_posted_by->user_data->name }}</span>
                        <span><i class="fa fa-calendar" style="color: #bf0223;"></i> {{ $and->posted_at }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
                <h5 class="text-center mb-3">Tidak Ada Pengumuman</h5>
            @endif
            {{-- <div class="text-button">
              <a href="{{ url('/documents') }}">Lihat Semua Pengumuman</a>
            </div> --}}
          </div>
          <div class="document-detail-column-category">
            <div class="heading-section">
                <h4>Kategori</h4>
            </div>
            <div class="col-12 align-self-center">
                <ul>
                    @foreach ($document_categories as $dc)
                        <li><a href="{{ url('/documents?category='. $dc->id) }}">{{ $dc->name }} <span>{{ $dc->documents_count }}</span></a></li>
                    @endforeach
                </ul>
            </div>
          </div>
      </div>
</div>
</div>
<!-- ***** Details End ***** -->

@endsection
