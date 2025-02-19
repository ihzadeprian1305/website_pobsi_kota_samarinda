@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Struktur</h3>
                <p class="text-subtitle text-muted">Tambah Data Struktur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/structures">Data Struktur</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Struktur</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/structures') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="structures_image_create">Foto</label>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_structures_image_create">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_name_create">Nama</label>
                        <input type="text" class="form-control" id="structures_name_create" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_name_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_born_date_create">Tanggal Lahir</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="born_date" id="structures_born_date_create" value="{{ old('born_date') }}" placeholder="Pilih Tanggal Lahir">
                        @error('born_date')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_born_date_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_sex_create">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="structures_sex_create" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_sex_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_description_create">Deskripsi</label>
                        <textarea name="description" id="structures_description_create" value="{{ old('description') }}"></textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Posisi</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="structures_structure_position_id_create" name="structure_position_id" value="{{ old('structures_position_id') }}">
                            </select>
                        </fieldset>
                        @error('structure_position_id')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_structure_position_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_structures_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    var structuresSexCreateDropdown = null;
    var structuresStructurePositionIdCreateDropdown = null;
    var availablePositions = @json($availablePositions);

    $(document).ready(function(){
        structuresSexCreateDropdown = new Choices('#structures_sex_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        structuresSexCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldSex = "{{ old('sex') }}";

                var choices = [
                    { value: 'Laki-laki', label: 'Laki-laki' },
                    { value: 'Perempuan', label: 'Perempuan' },
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

        $('#structures_born_date_create').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
        });

        structuresStructurePositionIdCreateDropdown = new Choices('#structures_structure_position_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari Posisi',
            placeholderValue: 'Pilih Posisi'
        });

        structuresStructurePositionIdCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-structure-position-dropdown-values', function(data) {
                    var choices = [];
                    // $.each(data, function(key, value) {
                    //     choices.push({ label: value, value: key });
                    // });

                    $.each(data, function(key, value) {
                        // choices.push({ label: value, value: key });
                        if (availablePositions.includes(parseInt(key))) {
                            choices.push({ label: value, value: key });
                        }
                    });

                    var oldValue = "{{ old('structure_position_id') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });
                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#structures_description_create').summernote({
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
