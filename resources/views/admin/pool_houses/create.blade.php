@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Rumah Biliard</h3>
                <p class="text-subtitle text-muted">Tambah Data Rumah Biliard</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/pool-houses">Data Rumah Biliard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Rumah Biliard</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/pool-houses') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="pool_houses_name_create">Nama Rumah Biliard</label>
                        <input type="text" class="form-control" id="pool_houses_name_create" name="name" value="{{ old('name') }}" placeholder="Masukkan Kegiatan">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_name_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_address_create">Alamat</label>
                        <textarea name="address" id="pool_houses_address_create">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="text-danger mt-2" role="alert" id="alert_pool_houses_address_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_link_address_create">Tautan Alamat (Google Maps->Share->Embed a Map)</label>
                        <textarea name="link_address" id="pool_houses_link_address_create">{{ old('link_address') }}</textarea>
                        @error('link_address')
                        <div class="text-danger mt-2" role="alert" id="alert_pool_houses_link_address_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_description_create">Deskripsi Rumah Biliard</label>
                        <textarea name="description" id="pool_houses_description_create">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_owner_name_create">Nama Pemilik</label>
                        <input type="text" class="form-control" id="pool_houses_owner_name_create" name="owner_name" value="{{ old('owner_name') }}" placeholder="Masukkan Nama Pemilik">
                        @error('owner_name')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_owner_name_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_house_phone_number_create">Nomor Handphone</label>
                        <input type="text" class="form-control" id="pool_house_phone_number_create" name="phone_number" value="{{ old('phone_number') }}" placeholder="Masukkan Nomor Handphone">
                        @error('phone_number')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_house_phone_number_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="pool_houses_open_time_create">Waktu Buka</label>
                                <input type="date" class="form-control flatpickr-no-config mb-3" name="open_time" id="pool_houses_open_time_create" placeholder="Masukkan Jam Mulai">
                                @error('open_time')
                                    <div class="text-danger mt-2" role="alert" id="alert_pool_houses_open_time_create">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="pool_houses_close_time_create">Waktu Tutup</label>
                                <input type="date" class="form-control flatpickr-no-config mb-3" name="close_time" id="pool_houses_close_time_create" placeholder="Masukkan Jam Tutup">
                                @error('close_time')
                                    <div class="text-danger mt-2" role="alert" id="alert_pool_houses_close_time_create">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_image_create">Foto Rumah Biliard</label>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="pool_houses_image_create" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_pool_houses_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        $('#pool_houses_open_time_create').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultDate: "{{ old('open_time') }}",
        });

        $('#pool_houses_close_time_create').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultDate: "{{ old('close_time') }}",
        });

        $('#pool_houses_address_create').summernote({
            toolbar: [],
            height: 300,
            minHeight: null,
            maxHeight: null,
        }).summernote('code', `{!! old('address') !!}`);

        $('#pool_houses_link_address_create').summernote({
            toolbar: [],
            height: 300,
            minHeight: null,
            maxHeight: null,
        }).summernote('code', `{!! old('link_address') !!}`);

        $('#pool_houses_description_create').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        }).summernote('code', `{!! old('description') !!}`);
    });
</script>
@endsection
