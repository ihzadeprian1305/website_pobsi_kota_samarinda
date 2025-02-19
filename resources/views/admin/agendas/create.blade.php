@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Agenda</h3>
                <p class="text-subtitle text-muted">Tambah Data Agenda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/agendas">Data Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Agenda</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/agendas') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="agendas_date_create">Tanggal</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="date" id="agendas_date_create" value="{{ old('date') }}" placeholder="Pilih Tanggal">
                        @error('date')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_date_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_time_create">Waktu</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="time" id="agendas_time_create" value="{{ old('time') }}" placeholder="Masukkan Jam Mulai">
                        @error('time')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_time_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_activity_create">Kegiatan</label>
                        <input type="text" class="form-control" id="agendas_activity_create" name="activity" value="{{ old('activity') }}" placeholder="Masukkan Kegiatan">
                        @error('activity')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_activity_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_description_create">Deskripsi Kegiatan</label>
                        <textarea name="description" id="agendas_description_create" value="{{ old('description') }}"></textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_location_create">Lokasi</label>
                        <input type="text" class="form-control" id="agendas_location_create" name="location" value="{{ old('location') }}" placeholder="Masukkan Kegiatan">
                        @error('location')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_location_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_attended_by_create">Dihadiri Oleh</label>
                        <input type="text" class="form-control" id="agendas_attended_by_create" name="attended_by" value="{{ old('attended_by') }}" placeholder="Masukkan Kegiatan">
                        @error('attended_by')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_attended_by_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_agendas_description_create">
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
        $('#agendas_date_create').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
        });

        $('#agendas_time_create').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
        });

        $('#agendas_description_create').summernote({
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        }).summernote('code', `{!! old('description') !!}`);
    });
</script>
@endsection
