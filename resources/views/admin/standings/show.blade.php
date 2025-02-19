@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Handicap/Klasemen</h3>
                <p class="text-subtitle text-muted">Lihat Data Handicap/Klasemen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/agendas">Data Handicap/Klasemen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Handicap/Klasemen</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($standing->athletes->athlete_images->image)
                        <div class="row gallery">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$standing->athletes->athlete_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-center mb-3">Foto Tidak Ditemukan</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="standing_name_show">Nama</label>
                    <input type="text" class="form-control" name="name" id="standing_name_show" value="{{ $standing->athletes->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="standing_handicap_show">Handicap/Klasemen</label>
                    <input type="text" class="form-control" name="standing_handicap" id="standing_handicap_show" value="{{ $standing->handicaps->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="standing_total_points_show">Total Poin</label>
                    <input type="text" class="form-control" name="standing_total_points" id="standing_total_points_show" value="{{ $standing->total_points }}" disabled>
                </div>
                <div class="form-group">
                    <label for="standing_description_show">Keterangan</label>
                    <textarea name="description" id="standing_description_show"></textarea>
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
                            <img class="d-block w-100" src="{{ asset('storage/'.$standing->athletes->athlete_images->image) }}">
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
        $('#standing_description_show').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        });
        $('#standing_description_show').summernote('code', `{!! $standing->description !!}`);
        $('#standing_description_show').summernote('disable');
    });
</script>
@endsection
