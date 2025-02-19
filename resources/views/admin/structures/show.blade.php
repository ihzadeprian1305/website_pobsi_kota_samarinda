@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Struktur</h3>
                <p class="text-subtitle text-muted">Lihat Data Struktur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/structures">Data Struktur</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Struktur</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($structure->structure_images->image)
                        <div class="row gallery">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$structure->structure_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-center mb-3">Foto Tidak Ditemukan</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="structures_name_show">Nama</label>
                    <input type="text" class="form-control" name="name" id="structures_name_show" value="{{ $structure->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="structures_born_date_show">Tanggal Lahir</label>
                    <input type="text" class="form-control" name="born_date" id="structures_born_date_show" value="{{ $structure->born_date }}" disabled>
                </div>
                <div class="form-group">
                    <label for="structures_sex_show">Jenis Kelamin</label>
                    <input type="text" class="form-control" name="sex" id="structures_sex_show" value="{{ $structure->sex }}" disabled>
                </div>
                <div class="form-group">
                    <label for="structures_description_show">Deskripsi Kegiatan</label>
                    <textarea name="description" id="structures_description_show">{{ $structure->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="structures_position_id_show">Posisi</label>
                    <input type="text" class="form-control" name="name" id="structures_position_id_show" value="{{ $structure->structure_positions->name }}" disabled>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Struktur</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/'.$structure->structure_images->image) }}">
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
        $('#structures_description_show').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
            code: `{!! $structure->description !!}`
        }).summernote('disable');
    });
</script>
@endsection
