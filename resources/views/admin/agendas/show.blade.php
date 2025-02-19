@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Agenda</h3>
                <p class="text-subtitle text-muted">Lihat Data Agenda</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/agendas">Data Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Agenda</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="agendas_date_show">Tanggal</label>
                    <input type="text" class="form-control" name="date" id="agendas_date_show" value="{{ $agenda->date }}" disabled>
                </div>
                <div class="form-group">
                    <label for="agendas_time_show">Waktu</label>
                    <input type="text" class="form-control" name="time" id="agendas_time_show" value="{{ $agenda->time }}" disabled>
                </div>
                <div class="form-group">
                    <label for="agendas_activity_show">Kegiatan</label>
                    <input type="text" class="form-control" name="activity" id="agendas_activity_show" value="{{ $agenda->activity }}" disabled>
                </div>
                <div class="form-group">
                    <label for="agendas_description_show">Deskripsi Kegiatan</label>
                    <textarea name="description" id="agendas_description_show">{{ $agenda->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="agendas_location_show">Lokasi</label>
                    <input type="text" class="form-control" name="agendas_location" id="agendas_location_show" value="{{ $agenda->location }}" disabled>
                </div>
                <div class="form-group">
                    <label for="agendas_attended_by_show">Dihadiri Oleh</label>
                    <input type="text" class="form-control" name="agendas_attended_by" id="agendas_attended_by_show" value="{{ $agenda->attended_by }}" disabled>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        $('#agendas_description_show').summernote({
            toolbar: [],
            height: 200,
            minHeight: null,
            maxHeight: null,
            disableDragAndDrop: true,
        });
        $('#agendas_description_show').summernote('code', `{!! $agenda->description !!}`);
        $('#agendas_description_show').summernote('disable');
    });
</script>
@endsection
