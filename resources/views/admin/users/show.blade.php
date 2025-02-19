@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengguna</h3>
                <p class="text-subtitle text-muted">Lihat Data Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/users">Data Pengguna</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Pengguna</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($user->user_images->image)
                        <div class="row">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3 gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$user->user_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3 gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <a href="#">
                                    <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('assets/static/images/profile-image/default_profile_image.png') }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_name_show">Nama</label>
                            <input type="text" class="form-control" id="user_name_show" name="name" value="{{ $user->user_data->name }}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_sex_show">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="user_sex_show" name="sex" value="{{ $user->user_data->sex }}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_email_show">Email</label>
                            <input type="email" class="form-control" id="user_email_show" name="email" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_phone_number_show">Nomor Handphone</label>
                            <input type="text" class="form-control" id="user_phone_number_show" name="phone_number" value="{{ $user->phone_number }}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Level Pengguna</label>
                            <input type="text" class="form-control" id="user_user_level_id_show" name="user_level_id" value="{{ $user->user_levels->name }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Foto Pengguna</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($user->user_images->image)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/'.$user->user_images->image) }}">
                            </div>
                        @else
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('assets/static/images/profile-image/default_profile_image.png') }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
