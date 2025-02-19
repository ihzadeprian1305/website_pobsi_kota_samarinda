@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Handicap/Klasemen</h3>
                <p class="text-subtitle text-muted">Tambah Data Handicap/Klasemen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/standings">Data Handicap/Klasemen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Handicap/Klasemen</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/standings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="standings_athlete_id_create">Atlet</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="athlete_id" id="standings_athlete_id_create" value="{{ old('athlete_id') }}">
                            </select>
                        </fieldset>
                        @error('athlete_id')
                            <div class="text-danger mt-2" role="alert" id="alert_standings_athlete_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="standings_handicap_id_create">Handicap/Klasemen</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="handicap_id" id="standings_handicap_id_create" value="{{ old('handicap_id') }}">
                            </select>
                        </fieldset>
                        @error('handicap_id')
                            <div class="text-danger mt-2" role="alert" id="alert_standings_handicap_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="standings_total_points_create">Poin</label>
                        <input type="text" class="form-control" id="standings_total_points_create" name="total_points" value="{{ old('total_points') }}" placeholder="Masukkan Poin">
                        @error('total_points')
                            <div class="text-danger mt-2" role="alert" id="alert_standings_total_points_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="standings_description_create">Deskripsi</label>
                        <textarea name="description" id="standings_description_create" value="{{ old('description') }}"></textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_standings_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_standings_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        var existingAthleteIds = @json($existingAthleteIds);

        var athleteCreateDropdown = new Choices('#standings_athlete_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Atlet'
        });

        athleteCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-athlete-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        // choices.push({ label: value, value: key });
                        if (!existingAthleteIds.includes(parseInt(key))) {
                            choices.push({ label: value, value: key });
                        }
                    });

                    var oldValue = "{{ old('athlete_id') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        var handicapCreateDropdown = new Choices('#standings_handicap_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Handicap/Klasemen'
        });

        handicapCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-handicap-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('handicap_id') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#standings_description_create').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['codeview', 'help']]
            ],
            disableDragAndDrop: true,
        }).summernote('code', `{!! old('description') !!}`);
    });
</script>
@endsection
