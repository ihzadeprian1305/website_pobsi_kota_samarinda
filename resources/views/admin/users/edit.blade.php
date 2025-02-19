@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengguna</h3>
                <p class="text-subtitle text-muted">Ubah Data Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/users">Data Pengguna</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Pengguna</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if ($user->user_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$user->user_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                            <form action="{{ url('/admin/users/'. $user->user_images->id . '/delete-image') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mt-1 d-flex mx-auto" type="submit">Hapus</button>
                            </form>
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
                <form action="{{ url('/admin/users/'.$user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="user_image_create">Foto Pengguna</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Foto Pengguna</div>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_user_image_create">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_user_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_name_edit">Nama</label>
                        <input type="text" class="form-control" id="user_name_edit" name="name" value="{{ old('name', $user->user_data->name) }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_user_name_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_username_edit">Username</label>
                        <input type="text" class="form-control" id="user_username_edit" name="username" value="{{ old('username', $user->username) }}" placeholder="Masukkan Username">
                        @error('username')
                            <div class="text-danger mt-2" role="alert" id="alert_user_username_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_sex_edit">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="user_sex_edit" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_user_sex_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_email_edit">Email</label>
                        <input type="email" class="form-control" id="user_email_edit" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email">
                        @error('email')
                            <div class="text-danger mt-2" role="alert" id="alert_user_email_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_phone_number_edit">Nomor Handphone</label>
                        <input type="text" class="form-control" id="user_phone_number_edit" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Masukkan Nomor Handphone">
                        @error('phone_number')
                            <div class="text-danger mt-2" role="alert" id="alert_user_phone_number_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_password_edit">Password</label>
                        <input type="password" class="form-control" id="user_password_edit" name="password" value="{{ old('password') }}" placeholder="Masukkan Password">
                        @error('password')
                            <div class="text-danger mt-2" role="alert" id="alert_user_password_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_password_confirmation_edit">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="user_password_confirmation_edit" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Masukkan Konfirmasi Password">
                        @error('password_confirmation')
                            <div class="text-danger mt-2" role="alert" id="alert_user_password_confirmation_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Level Pengguna</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="user_user_level_id_edit" name="user_level_id" value="{{ old('user_level_id') }}">
                            </select>
                        </fieldset>
                        @error('user_level_id')
                            <div class="text-danger mt-2" role="alert" id="alert_user_user_level_id_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit-btn-user-edit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
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
<script>
    var userSexEditDropdown = null;
    var userLevelEditDropdown = null;

    $(function() {
        userSexEditDropdown = new Choices('#user_sex_edit', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        userSexEditDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldSex = "{{ old('sex', $user->user_data->sex) }}";

                var choices = [
                    { value: 'Laki-laki', label: 'Laki-laki' },
                    { value: 'Perempuan', label: 'Perempuan' },
                    { value: 'Lainnya', label: 'Lainnya (Peruntukan Untuk Tim, Kelompok, dan Sejenisnya)' }
                ];

                if (oldSex) {
                    choices.forEach(function(choice) {
                        if (choice.value === oldSex) {
                            choice.selected = true;
                        }
                    });
                }
                resolve(choices);
            });
        }, 'value', 'label', true);

        userLevelEditDropdown = new Choices('#user_user_level_id_edit', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari Level Pengguna',
            placeholderValue: 'Pilih Level Pengguna'
        });

        userLevelEditDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-user-level-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('user_level_id', $user->user_level_id) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });
                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);
    });
</script>
@endsection
