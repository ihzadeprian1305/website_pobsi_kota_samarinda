@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Atlet</h3>
                <p class="text-subtitle text-muted">Tambah Data Atlet</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/athletes">Data Atlet</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Atlet</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/athletes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="athletes_image_create">Foto Atlet</label>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_athletes_image_create">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_name_create">Nama</label>
                        <input type="text" class="form-control" id="athletes_name_create" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_name_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_born_date_create">Tanggal Lahir</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="born_date" id="athletes_born_date_create" value="{{ old('born_date') }}" placeholder="Pilih Tanggal Lahir Atlet">
                        @error('born_date')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_born_date_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_sex_create">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="athletes_sex_create" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_sex_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_career_description_create">Deskripsi Karir</label>
                        <textarea name="career_description" id="athletes_career_description_create">{{ old('career_description') }}</textarea>
                        @error('career_description')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_career_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_athletes_career_description_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    var athletesSexCreateDropdown = null;

    $(document).ready(function(){
        athletesSexCreateDropdown = new Choices('#athletes_sex_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        athletesSexCreateDropdown.setChoices(function() {
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

        $('#athletes_born_date_create').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
        });

        $('#athletes_career_description_create').summernote({
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
        }).summernote('code', `{!! old('career_description') !!}`);
    });
</script>
@endsection
