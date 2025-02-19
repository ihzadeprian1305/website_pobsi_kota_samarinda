@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Berita</h3>
                <p class="text-subtitle text-muted">Ubah Data Berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/news">Data Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Berita</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if ($news->news_cover_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-slide-to="1" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$news->news_cover_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <form action="{{ url('/admin/news/'.$news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="news_cover_image_update">Sampul Berita</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Sampul Berita</div>
                        <input type="file" class="image-preview-filepond" name="cover_image" id="news_cover_image_update">
                        @error('cover_image')
                            <div class="text-danger mt-2" role="alert" id="alert_news_cover_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_title_update">Judul</label>
                        <input type="text" class="form-control" name="title" id="news_title_update" value="{{ old('title', $news->title) }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_news_title_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_slug_update">Slug</label>
                        <input type="text" class="form-control" name="slug" id="news_slug_update" value="{{ old('slug', $news->slug) }}" readonly placeholder="Masukkan Slug">
                        @error('slug')
                            <div class="text-danger mt-2" role="alert" id="alert_news_slug_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_content_update">Isi Berita</label>
                        <textarea name="content" id="news_content_update">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <div class="text-danger mt-2" role="alert" id="alert_news_content_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_is_active_update">Kategori</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="news_category_id" id="news_news_category_id_update" value="{{ old('news_category_id', $news->news_category_id) }}">
                            </select>
                        </fieldset>
                        @error('news_category_id')
                            <div class="text-danger mt-2" role="alert" id="alert_news_news_category_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_news_tag_id_update">Tag</label>
                        <fieldset class="form-group">
                            <select class="form-select multiple-remove" name="news_tag_id[]" id="news_news_tag_id_update" multiple="multiple" value="{{ old('news_tag_id[]', $news->news_tags) }}">
                            </select>
                        </fieldset>
                        @error('news_tag_id')
                            <div class="text-danger mt-2" role="alert" id="alert_news_news_tag_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_created_by_update">Dibuat Oleh</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="created_by" id="news_created_by_update" value="{{ old('created_by', $news->created_by) }}">
                            </select>
                        </fieldset>
                        @error('created_by')
                            <div class="text-danger mt-2" role="alert" id="alert_news_created_by_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_is_active_update">Aktif</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_active" id="news_is_active_update" value="{{ old('is_active', $news->is_active) }}">
                            </select>
                        </fieldset>
                        @error('is_active')
                            <div class="text-danger mt-2" role="alert" id="alert_news_is_active_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="news_image_update">Foto Berita</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Menambah Gambar | Masukkan Jika Ingin Menambah Gambar</div>
                        <input type="file" class="multiple-files-filepond" name="image[]" id="news_image_update" multiple>
                        @error('image')
                            <div class="text-danger mt-2" role="alert" id="alert_news_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_news_category_update">
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
                @if (count($news->news_images) > 0)
                    <div class="row gallery">
                        @foreach($news->news_images as $ni)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index + 1 }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                    <img class="w-100" src="{{ asset('storage/'.$ni->image) }}">
                                </a>
                                <form action="{{ url('/admin/news/'. $ni->id . '/delete-image') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
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
                <h5 class="modal-title" id="galleryModalTitle">Foto Berita</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @if($news->news_cover_images)
                            <button
                                type="button"
                                data-bs-target="#Gallerycarousel"
                                data-bs-slide-to="0"
                                class="active"
                                aria-current="true"
                                aria-label="Slide 1">
                            </button>
                        @endif
                        @foreach($news->news_images as $index => $ni)
                            <button
                                type="button"
                                data-bs-target="#Gallerycarousel"
                                data-bs-slide-to="{{ $index + ($news->news_cover_images ? 1 : 0) }}"
                                class="{{ $index == 0 && !$news->news_cover_images ? 'active' : '' }}"
                                aria-current="{{ $index == 0 && !$news->news_cover_images ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + ($news->news_cover_images ? 2 : 1) }}">
                            </button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @if($news->news_cover_images)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('storage/'.$news->news_cover_images->image) }}" alt="Cover Image">
                            </div>
                        @endif
                        @foreach($news->news_images as $index => $ni)
                            <div class="carousel-item {{ $index == 0 && !$news->news_cover_images ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset('storage/'.$ni->image) }}" alt="Image {{ $index + 1 }}">
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
    var newsIsActiveCreateDropdown = null;
    var newsNewsCategoryCreateDropdown = null;
    var newsNewsTagCreateDropdown = null;
    var newsCreatedByCreateDropdown = null;

    $('#news_title_update').on('keyup', function() {
        $.ajax({
            url: '/admin/news/check-slug',
            type: 'GET',
            data: {title: $(this).val()},
            dataType: 'json',
            success: function(data) {
                $('#news_slug_update').val(data.slug);
            },
            error: function(error) {
                console.error('Error checking slug:', error);
            }
        });
    });

    $(document).ready(function () {
        newsIsActiveCreateDropdown = new Choices('#news_is_active_update', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Berita',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        newsIsActiveCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldIsActive = "{{ old('is_active', $news->is_active) }}";
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

        newsNewsCategoryCreateDropdown = new Choices('#news_news_category_id_update', {
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

                    var oldValue = "{{ old('news_category_id', $news->news_category_id) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        newsNewsTagCreateDropdown = new Choices('#news_news_tag_id_update', {
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

                    var oldValues = "{{ json_encode(old('news_tag_id', $news->news_tags->pluck('id')->toArray())) }}";

                    choices.forEach(function(choice) {
                        if (oldValues.includes(choice.value.toString())) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        newsCreatedByCreateDropdown = new Choices('#news_created_by_update', {
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

                    var oldValue = "{{ old('created_by', $news->created_by) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);

        $('#news_content_update').summernote({
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
        }).summernote('code', `{!! old('content', $news->content) !!}`);
    });
</script>
@endsection
