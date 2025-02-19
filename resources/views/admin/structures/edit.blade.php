@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Struktur</h3>
                <p class="text-subtitle text-muted">Ubah Data Struktur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/structures">Data Struktur</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Struktur</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if ($structure->structure_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$structure->structure_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <form action="{{ url('/admin/structures/'.$structure->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="structures_image_update">Foto Struktur</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Foto Struktur</div>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_structures_image_update">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_name_update">Nama</label>
                        <input type="text" class="form-control" id="structures_name_update" name="name" value="{{ old('name', $structure->name) }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_name_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_born_date_update">Tanggal Lahir</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="born_date" id="structures_born_date_update" value="{{ old('born_date', $structure->born_date) }}" placeholder="Pilih Tanggal Lahir Struktur">
                        @error('born_date')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_born_date_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_sex_update">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="structures_sex_update" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_sex_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="structures_description_update">Deskripsi</label>
                        <textarea name="description" id="structures_description_update">{{ old('description', $structure->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_description_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Posisi</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="structures_structure_position_id_update" name="structure_position_id" value="{{ old('structures_position_id') }}">
                            </select>
                        </fieldset>
                        @error('structure_position_id')
                            <div class="text-danger mt-2" role="alert" id="alert_structures_structure_position_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="structureagenda_update">
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
                <h5 class="modal-title" id="galleryModalTitle">Foto Struktur</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($structure->structure_images->image)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/'.$structure->structure_images->image) }}">
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
    var structuresSexUpdateDropdown = null;
    var structuresStructurePositionIdUpdateDropdown = null;
    var availablePositions = @json($availablePositions);

    $(document).ready(function(){
        structuresSexUpdateDropdown = new Choices('#structures_sex_update', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        structuresSexUpdateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldSex = "{{ old('sex', $structure->sex) }}";

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

        structuresStructurePositionIdCreateDropdown = new Choices('#structures_structure_position_id_update', {
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

                    var oldValue = "{{ old('structure_position_id', $structure->structure_position_id) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });
                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#structures_born_date_update').flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            defaultDate: "{{ old('born_date', $structure->born_date) }}",
        });

        $('#structures_description_update').summernote({
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
        }).summernote('code', `{!! old('description', $structure->description) !!}`);
    });
</script>
@endsection
