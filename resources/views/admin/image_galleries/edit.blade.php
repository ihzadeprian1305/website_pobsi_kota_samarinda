@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Galeri Foto</h3>
                <p class="text-subtitle text-muted">Ubah Data Galeri Foto</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/image-galleries">Data Galeri Foto</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Galeri Foto</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/image-galleries/'.$imageGallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="image_galleries_title_update">Judul</label>
                        <input type="text" class="form-control" id="image_galleries_title_update" name="title" value="{{ old('title', $imageGallery->title) }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_title_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_galleries_caption_update">Penjelasan Singkat</label>
                        <input type="text" class="form-control" id="image_galleries_caption_update" name="caption" value="{{ old('caption', $imageGallery->caption) }}" placeholder="Masukkan Penjelasan Singkat">
                        @error('caption')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_caption_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_galleries_image_update">Gambar</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Menambah Gambar | Masukkan Jika Ingin Menambah Gambar | Wajib Menambahkan Gambar Jika Tidak Terdapat Gambar Sama Sekali</div>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="image_galleries_image_update" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_image_galleries_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="imageGalleryagenda_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Hapus Foto Galeri Foto</h4>
            </div>
            <div class="card-body">
                @if (count($imageGallery->image_gallery_images) > 0)
                    <div class="row gallery">
                        @foreach($imageGallery->image_gallery_images as $igi)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                    <img class="w-100" src="{{ asset('storage/'.$igi->image) }}">
                                </a>
                                <form action="{{ url('/admin/image-galleries/'. $igi->id . '/delete-image') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mt-1 d-flex mx-auto" type="submit">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
