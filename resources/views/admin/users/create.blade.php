@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengguna</h3>
                <p class="text-subtitle text-muted">Tambah Data Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/users">Data Pengguna</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Pengguna</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/users') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_image_create">Foto Pengguna</label>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_user_image_create">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_user_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_name_create">Nama</label>
                        <input type="text" class="form-control" id="user_name_create" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_user_name_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_username_create">Username</label>
                        <input type="text" class="form-control" id="user_username_create" name="username" value="{{ old('username') }}" placeholder="Masukkan Username">
                        @error('username')
                            <div class="text-danger mt-2" role="alert" id="alert_user_username_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_sex_create">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="user_sex_create" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_user_sex_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_email_create">Email</label>
                        <input type="email" class="form-control" id="user_email_create" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
                        @error('email')
                            <div class="text-danger mt-2" role="alert" id="alert_user_email_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_phone_number_create">Nomor Handphone</label>
                        <input type="text" class="form-control" id="user_phone_number_create" name="phone_number" value="{{ old('phone_number') }}" placeholder="Masukkan Nomor Handphone">
                        @error('phone_number')
                            <div class="text-danger mt-2" role="alert" id="alert_user_phone_number_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_password_create">Password</label>
                        <input type="password" class="form-control" id="user_password_create" name="password" value="{{ old('password') }}" placeholder="Masukkan Password">
                        @error('password')
                            <div class="text-danger mt-2" role="alert" id="alert_user_password_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_password_confirmation_create">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="user_password_confirmation_create" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Masukkan Konfirmasi Password">
                        @error('password_confirmation')
                            <div class="text-danger mt-2" role="alert" id="alert_user_password_confirmation_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Level Pengguna</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="user_user_level_id_create" name="user_level_id" value="{{ old('user_level_id') }}">
                            </select>
                        </fieldset>
                        @error('user_level_id')
                            <div class="text-danger mt-2" role="alert" id="alert_user_user_level_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_user_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    var userSexCreateDropdown = null;
    var userLevelCreateDropdown = null;

    $(function() {

        userSexCreateDropdown = new Choices('#user_sex_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        userSexCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldSex = "{{ old('sex') }}";

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

        userLevelCreateDropdown = new Choices('#user_user_level_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari Level Pengguna',
            placeholderValue: 'Pilih Level Pengguna'
        });

        userLevelCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-user-level-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('user_level_id') }}";

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
