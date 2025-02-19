@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Agenda</h3>
                <p class="text-subtitle text-muted">Ubah Data Agenda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/agendas">Data Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Agenda</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/agendas/'.$agenda->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="agendas_date_update">Tanggal</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="date" id="agendas_date_update" value="{{ old('date', $agenda->date) }}" placeholder="Pilih Tanggal">
                        @error('date')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_date_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_time_update">Waktu</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="time" id="agendas_time_update" value="{{ old('time', $agenda->time) }}" placeholder="Masukkan Jam Mulai">
                        @error('time')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_time_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_activity_update">Kegiatan</label>
                        <input type="text" class="form-control" id="agendas_activity_update" name="activity" value="{{ old('activity', $agenda->activity) }}" placeholder="Masukkan Kegiatan">
                        @error('activity')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_activity_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_description_update">Deskripsi Kegiatan</label>
                        <textarea name="description" id="summernote">{{ old('description', $agenda->description) }}</textarea>
                        @error('descriptioin')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_description_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_location_update">Lokasi</label>
                        <input type="text" class="form-control" id="agendas_location_update" name="location" value="{{ old('location', $agenda->location) }}" placeholder="Masukkan Kegiatan">
                        @error('location')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_location_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agendas_attended_by_update">Dihadiri Oleh</label>
                        <input type="text" class="form-control" id="agendas_attended_by_update" name="attended_by" value="{{ old('attended_by', $agenda->attended_by) }}" placeholder="Masukkan Kegiatan">
                        @error('attended_by')
                            <div class="text-danger mt-2" role="alert" id="alert_agendas_attended_by_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_agenda_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        $('#agendas_date_update').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                defaultDate: "{{ old('date', $agenda->date) }}",
        });

        $('#agendas_time_update').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultDate: "{{ old('time', $agenda->time) }}",
        });

        $('#agendas_description_update').summernote({
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        }).summernote('code', `{!! old('description', $agenda->description) !!}`);
    });
</script>
@endsection
