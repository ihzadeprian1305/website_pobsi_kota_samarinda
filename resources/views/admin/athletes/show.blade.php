@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Atlet</h3>
                <p class="text-subtitle text-muted">Lihat Data Atlet</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/athletes">Data Atlet</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Atlet</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($athlete->athlete_images->image)
                        <div class="row gallery">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$athlete->athlete_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-center mb-3">Foto Tidak Ditemukan</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="athletes_name_show">Nama</label>
                    <input type="text" class="form-control" name="name" id="athletes_name_show" value="{{ $athlete->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="athletes_pool_house_show">Sarana Olahraga Naungan</label>
                    <input type="text" class="form-control" name="name" id="athletes_pool_house_show" value="{{ $athlete->pool_houses->name ?? $athlete->another_pool_house }}" disabled>
                </div>
                <div class="form-group">
                    <label for="athletes_pool_house_show">Handicap/Klasemen</label>
                    <input type="text" class="form-control" name="name" id="athletes_handicap_id_show" value="{{ $athlete->standings->handicaps->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="athletes_born_date_show">Tanggal Lahir</label>
                    <input type="text" class="form-control" name="athletes_born_date" id="athletes_born_date_show" value="{{ $athlete->born_date }}" disabled>
                </div>
                <div class="form-group">
                    <label for="athletes_sex_show">Jenis Kelamin</label>
                    <input type="text" class="form-control" name="name" id="athletes_sex_show" value="{{ $athlete->sex }}" disabled>
                </div>
                <div class="form-group">
                    <label for="athletes_career_description_show">Deskripsi Kegiatan</label>
                    <textarea name="career_description" id="summernote">{{ $athlete->career_description }}</textarea>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Atlet</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/'.$athlete->athlete_images->image) }}">
                        </div>
                    </div>
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
        $('[name="career_description"]').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
            code: `{!! $athlete->career_description !!}`
        }).summernote('disable');

        $('#summernote').next('.note-editor').find('.note-toolbar').hide();
    });
</script>
@endsection
