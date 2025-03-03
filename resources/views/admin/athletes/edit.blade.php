@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Atlet</h3>
                <p class="text-subtitle text-muted">Ubah Data Atlet</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/athletes">Data Atlet</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Atlet</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if ($athlete->athlete_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$athlete->athlete_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <form action="{{ url('/admin/athletes/'.$athlete->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="athletes_image_update">Foto Atlet</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Foto Atlet</div>
                        <input type="file" class="image-preview-filepond" name="image" id="alert_athletes_image_update">
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_name_update">Nama</label>
                        <input type="text" class="form-control" id="athletes_name_update" name="name" value="{{ old('name', $athlete->name) }}" placeholder="Masukkan Nama">
                        @error('name')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_name_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_pool_house_id_update">Sarana Olahraga Naungan</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="pool_house_id" id="athletes_pool_house_id_update" value="{{ old('pool_house_id', $athlete->pool_house_id ?? '-') }}">
                            </select>
                        </fieldset>
                        @error('pool_house_id')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_pool_house_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_another_pool_house_update" id="label_athletes_another_pool_house_update">Sarana Olahraga Naungan Lainnya</label>
                        <input type="text" class="form-control" id="athletes_another_pool_house_update" name="another_pool_house" value="{{ old('another_pool_house', $athlete->another_pool_house) }}" placeholder="Masukkan Rumah Biliar Lainnya">
                        @error('another_pool_house')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_another_pool_house_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_handicap_update">Handicap/Klasemen</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="handicap_id" id="athletes_handicap_id_update" value="{{ $athlete->standings->handicap_id }}">
                            </select>
                        </fieldset>
                        @error('handicap_id')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_handicap_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_born_date_update">Tanggal Lahir</label>
                        <input type="date" class="form-control flatpickr-no-config mb-3" name="born_date" id="athletes_born_date_update" value="{{ old('born_date', $athlete->born_date) }}" placeholder="Pilih Tanggal Lahir Atlet">
                        @error('born_date')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_born_date_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_sex_edit">Jenis Kelamin</label>
                        <fieldset class="form-group">
                            <select class="form-select" id="athletes_sex_edit" name="sex" value="{{ old('sex') }}">
                            </select>
                        </fieldset>
                        @error('sex')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_sex_edit">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="athletes_career_description_update">Deskripsi Karir</label>
                        <textarea name="career_description" id="athletes_career_description_update">{{ old('career_description', $athlete->career_description) }}</textarea>
                        @error('career_description')
                            <div class="text-danger mt-2" role="alert" id="alert_athletes_career_description_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="athleteagenda_update">
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
                <h5 class="modal-title" id="galleryModalTitle">Foto Atlet</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($athlete->athlete_images->image)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/'.$athlete->athlete_images->image) }}">
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
    var athletesSexEditDropdown = null;

    $(document).ready(function(){
        if($('#athletes_pool_house_id_update').val() === ''){
            $('#athletes_another_pool_house_update').hide();
            $('#label_athletes_another_pool_house_update').hide();
        }
        if($('#athletes_pool_house_id_update').val() === '-'){
            $('#athletes_another_pool_house_update').show();
            $('#label_athletes_another_pool_house_update').show();
        }

        athletesPoolHouseUpdateDropdown = new Choices('#athletes_pool_house_id_update', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Rumah Biliar'
        });

        athletesPoolHouseUpdateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-pool-house-dropdown-values', function(data) {
                    var choices = [];
                    choices.push({ label: 'Lainnya', value: '-' });
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('pool_house_id', $athlete->pool_house_id ?? '-') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#athletes_pool_house_id_update').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === '-') {
                $('#athletes_another_pool_house_update').show();
                $('#label_athletes_another_pool_house_update').show();
            } else {
                $('#athletes_another_pool_house_update').hide();
                $('#athletes_another_pool_house_update').val('');
                $('#label_athletes_another_pool_house_update').hide();
            }
        });

        if ($('#athletes_pool_house_id_update').val() === '-') {
            $('#athletes_another_pool_house_update').show();
            $('#label_athletes_another_pool_house_update').show();
        }

        var handicapUpdateDropdown = new Choices('#athletes_handicap_id_update', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Handicap/Klasemen'
        });

        handicapUpdateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-handicap-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('handicap_id', $athlete->standings->handicap_id) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        athletesSexEditDropdown = new Choices('#athletes_sex_edit', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Jenis Kelamin'
        });

        athletesSexEditDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldSex = "{{ old('sex', $athlete->sex) }}";

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

        $('#athletes_born_date_update').flatpickr({
                enableTime: false,
                dateFormat: "Y-m-d",
                defaultDate: "{{ old('born_date', $athlete->born_date) }}",
        });

        $('#athletes_career_description_update').summernote({
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
        }).summernote('code', `{!! old('career_description', $athlete->career_description) !!}`);
    });
</script>
@endsection
