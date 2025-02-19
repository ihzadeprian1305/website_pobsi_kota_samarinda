@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Berita</h3>
                <p class="text-subtitle text-muted">Tambah Data Berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/news">Data Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Berita</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/news') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="news_cover_image_create">Sampul Berita</label>
                        <input type="file" class="image-preview-filepond" name="cover_image" id="news_cover_image_create">
                        @error('cover_image')
                            <div class="text-danger mt-2" role="alert" id="alert_news_cover_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_title_create">Judul</label>
                        <input type="text" class="form-control" name="title" id="news_title_create" value="{{ old('title') }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_news_title_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_slug_create">Slug</label>
                        <input type="text" class="form-control" name="slug" id="news_slug_create" value="{{ old('slug') }}" readonly placeholder="Masukkan Slug">
                        @error('slug')
                            <div class="text-danger mt-2" role="alert" id="alert_news_slug_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_content_create">Isi Berita</label>
                        <textarea name="content" id="news_content_create">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-danger mt-2" role="alert" id="alert_news_content_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_is_active_create">Kategori</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="news_category_id" id="news_news_category_id_create" value="{{ old('news_category_id') }}">
                            </select>
                        </fieldset>
                        @error('news_category_id')
                            <div class="text-danger mt-2" role="alert" id="alert_news_news_category_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_news_tag_id_create">Tag</label>
                        <fieldset class="form-group">
                            <select class="form-select multiple-remove" name="news_tag_id[]" id="news_news_tag_id_create" multiple="multiple" value="{{ old('news_tag_id[]') }}">
                            </select>
                        </fieldset>
                        @error('news_tag_id')
                            <div class="text-danger mt-2" role="alert" id="alert_news_news_tag_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_created_by_create">Dibuat Oleh</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="created_by" id="news_created_by_create" value="{{ old('created_by') }}">
                            </select>
                        </fieldset>
                        @error('created_by')
                            <div class="text-danger mt-2" role="alert" id="alert_news_created_by_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_is_active_create">Aktif</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_active" id="news_is_active_create" value="{{ old('is_active') }}">
                            </select>
                        </fieldset>
                        @error('is_active')
                            <div class="text-danger mt-2" role="alert" id="alert_news_is_active_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_image_create">Foto Berita Lainnya</label>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="news_image_create" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_news_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_news_category_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    var newsIsActiveCreateDropdown = null;
    var newsNewsCategoryCreateDropdown = null;
    var newsNewsTagCreateDropdown = null;
    var newsCreatedByCreateDropdown = null;

    $('#news_title_create').on('keyup', function() {
        $.ajax({
            url: '/admin/news/check-slug',
            type: 'GET',
            data: {title: $(this).val()},
            dataType: 'json',
            success: function(data) {
                $('#news_slug_create').val(data.slug);
            },
            error: function(error) {
                console.error('Error checking slug:', error);
            }
        });
    });

    $(document).ready(function () {
        newsIsActiveCreateDropdown = new Choices('#news_is_active_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Berita',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        newsIsActiveCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldIsActive = "{{ old('is_active') }}";
                var oldValue = parseInt(oldIsActive);

                var choices = [
                    { label: 'Ya', value: 1 },
                    { label: 'Tidak', value: 0 },
                ];

                if (oldIsActive) {
                    choices.forEach(function(choice) {
                        if (choice.value === oldValue) {
                            choice.selected = true;
                        }
                    });
                } else {
                    choices.forEach(function(choice) {
                        if (choice.value === 1) {
                            choice.selected = true;
                        }
                    });
                }

                resolve(choices);
            });
        }, 'value', 'label', true);

        newsNewsCategoryCreateDropdown = new Choices('#news_news_category_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Berita'
        });

        newsNewsCategoryCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-news-category-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('news_category_id') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        newsNewsTagCreateDropdown = new Choices('#news_news_tag_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari Tag',
            placeholderValue: 'Pilih Tag',
            removeItemButton: true,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            searchResultLimit: -1,
            searchEnabled: true
        });

        newsNewsTagCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-news-tag-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValues = "{{ json_encode(old('news_tag_id', [])) }}";

                    choices.forEach(function(choice) {
                        if (oldValues.includes(choice.value.toString())) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        newsCreatedByCreateDropdown = new Choices('#news_created_by_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari Pembuat Berita',
            placeholderValue: 'Pilih Pembuat Berita'
        });

        newsCreatedByCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-news-user-created-by-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('created_by') }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#news_content_create').summernote({
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
        }).summernote('code', `{!! old('content') !!}`);
    });
</script>
@endsection
