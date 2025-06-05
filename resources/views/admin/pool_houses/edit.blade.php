@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Rumah Biliar</h3>
                <p class="text-subtitle text-muted">Ubah Data Rumah Biliar</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/pool-houses">Data Rumah Biliar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Rumah Biliar</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/pool-houses/'.$poolHouse->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="pool_houses_name_update">Nama Rumah Biliard</label>
                        <input type="text" class="form-control" id="pool_houses_name_update" name="name" value="{{ old('name', $poolHouse->name) }}" placeholder="Masukkan Nama Rumah Biliar">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_name_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_address_update">Alamat</label>
                        <textarea name="address" id="pool_houses_address_update">{{ old('address', $poolHouse->address) }}</textarea>
                        @error('address')
                        <div class="text-danger mt-2" role="alert" id="alert_pool_houses_address_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_link_address_update">Tautan Alamat (Google Maps->Share->Embed a Map)</label>
                        <textarea name="link_address" id="pool_houses_link_address_update">{!! old('address', htmlspecialchars($poolHouse->link_address, ENT_QUOTES, 'UTF-8')) !!}</textarea>
                        @error('link_address')
                        <div class="text-danger mt-2" role="alert" id="alert_pool_houses_link_address_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_description_update">Deskripsi Rumah Biliard</label>
                        <textarea name="description" id="pool_houses_description_update">{{ old('description', $poolHouse->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_description_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_owner_name_update">Nama Pemilik</label>
                        <input type="text" class="form-control" id="pool_houses_owner_name_update" name="owner_name" value="{{ old('owner_name', $poolHouse->owner_name) }}" placeholder="Masukkan Nama Pemilik">
                        @error('owner_name')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_owner_name_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pool_house_phone_number_edit">Nomor Handphone</label>
                        <input type="text" class="form-control" id="pool_house_phone_number_edit" name="phone_number" value="{{ old('phone_number', $poolHouse->phone_number) }}" placeholder="Masukkan Nomor Handphone">
                        @error('phone_number')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_house_phone_number_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="pool_houses_open_time_update">Waktu Buka</label>
                                <input type="date" class="form-control flatpickr-no-config mb-3" name="open_time" id="pool_houses_open_time_update" placeholder="Masukkan Jam Mulai">
                                @error('open_time')
                                    <div class="text-danger mt-2" role="alert" id="alert_pool_houses_open_time_update">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="pool_houses_close_time_update">Waktu Tutup</label>
                                <input type="date" class="form-control flatpickr-no-config mb-3" name="close_time" id="pool_houses_close_time_update" placeholder="Masukkan Jam Tutup">
                                @error('close_time')
                                    <div class="text-danger mt-2" role="alert" id="alert_pool_houses_close_time_update">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pool_houses_image_update">Foto Rumah Biliard</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Menambah Gambar | Masukkan Jika Ingin Menambah Gambar | Wajib Menambahkan Gambar Jika Tidak Terdapat Gambar Sama Sekali</div>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="pool_houses_image_update" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_pool_houses_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_agenda_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Hapus Foto Rumah Biliar</h4>
            </div>
            <div class="card-body">
                @if (count($poolHouse->pool_house_images) > 0)
                    <div class="row gallery">
                        @foreach($poolHouse->pool_house_images as $phi)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                    <img class="w-100" src="{{ asset('storage/'.$phi->image) }}">
                                </a>
                                <form action="{{ url('/admin/pool-houses/'. $phi->id . '/delete-image') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
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
        $('#pool_houses_open_time_update').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultDate: "{{ old('open_time', $poolHouse->open_time) }}"
        });

        $('#pool_houses_close_time_update').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultDate: "{{ old('close_time', $poolHouse->close_time) }}",
        });

        $('#pool_houses_address_update').summernote({
            toolbar: [],
            height: 300,
            minHeight: null,
            maxHeight: null,
        });

        $('#pool_houses_link_address_update').summernote({
            toolbar: [],
            height: 300,
            minHeight: null,
            maxHeight: null,
        });

        $('#pool_houses_description_update').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        });
    });
</script>
@endsection
