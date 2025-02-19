@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Rumah Biliard</h3>
                <p class="text-subtitle text-muted">Lihat Data Rumah Biliard</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/pool-houses">Data Rumah Biliard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Rumah Biliard</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="pool_houses_date_show">Nama Rumah Biliard</label>
                    <input type="text" class="form-control" name="date" id="pool_houses_date_show" value="{{ $poolHouse->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="pool_houses_address_show">Alamat</label>
                    <textarea name="address" id="pool_houses_address_show" disabled>{{ $poolHouse->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="pool_houses_link_address_show">Tautan Alamat (Google Maps->Share->Embed a Map)</label>
                    <div class="embed-responsive embed-responsive-16by9">
                        {!! html_entity_decode($poolHouse->link_address) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="pool_houses_description_show">Deskripsi Rumah Biliard</label>
                    <textarea name="description" id="pool_houses_description_show" disabled>{{ $poolHouse->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="pool_houses_owner_name_show">Nama Pemilik</label>
                    <input type="text" class="form-control" name="pool_houses_owner_name_show" id="pool_houses_owner_name_show" value="{{ $poolHouse->owner_name }}" disabled>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="pool_houses_open_time_show">Waktu Buka</label>
                            <input type="text" class="form-control" name="pool_houses_open_time" id="pool_houses_open_time_show" value="{{ $poolHouse->open_time }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="pool_houses_close_time_show">Waktu Tutup</label>
                            <input type="text" class="form-control" name="pool_houses_close_time" id="pool_houses_close_time_show" value="{{ $poolHouse->close_time }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pool_houses_image_show">Foto Rumah Biliard</label>
                    @if (count($poolHouse->pool_house_images) > 0)
                        <div class="row gallery">
                            @foreach($poolHouse->pool_house_images as $phi)
                                <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                    <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                        <img class="w-100" src="{{ asset('storage/'.$phi->image) }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Foto Tidak Ditemukan</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Rumah Biliar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($poolHouse->pool_house_images as $index => $phi)
                            <button
                                type="button"
                                data-bs-target="#Gallerycarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index == 0 ? 'active' : '' }}"
                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($poolHouse->pool_house_images as $index => $phi)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset('storage/'.$phi->image) }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#Gallerycarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#Gallerycarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // const thumbnails = document.querySelectorAll('.thumbnail');

        // thumbnails.forEach(thumbnail => {
        //     thumbnail.addEventListener('click', function() {
        //         const slideIndex = this.getAttribute('data-bs-slide-to');
        //         const carousel = new bootstrap.Carousel(document.querySelector('#Gallerycarousel'));
        //         carousel.to(slideIndex);
        //     });
        // });

        $('#pool_houses_address_show').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
            code: `{!! $poolHouse->address !!}`
        }).summernote('disable');

        $('#pool_houses_description_show').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
            code: `{!! $poolHouse->description !!}`
        }).summernote('disable');
    });
</script>
@endsection
