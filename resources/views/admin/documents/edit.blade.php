@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Dokumen</h3>
                <p class="text-subtitle text-muted">Ubah Data Dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/documents">Data Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Dokumen</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                @if (isset($document->document_cover_images->image))
                    <div class="row gallery">
                        <div class="mx-auto d-block mb-3 col-6 col-sm-6 col-lg-3">
                            <a href="#" data-bs-slide-to="1" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="active rounded img-fluid" style="width: 15vw" src="{{ asset('storage/'.$document->document_cover_images->image) }}" data-bs-target="#Gallerycarousel" data-bs-slide-to="0">
                            </a>
                        </div>
                    </div>
                    <label for="documents_cover_image_update">Hapus Sampul Dokumen (Jika Tidak Memerlukan Sampul)</label>
                    <div class="list-group">
                        <a href="{{ Storage::url($document->document_cover_images->image) }}" target="_blank" class="list-group-item list-group-item-action my-1">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $document->document_cover_images->image }}</h5>
                                <form action="{{ url('/admin/documents/'. $document->document_cover_images->id . '/delete-image') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                            <small>Klik Untuk Lihat atau Unduh</small>
                        </a>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <form action="{{ url('/admin/documents/'.$document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="documents_cover_image_update">Sampul Dokumen</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Mengubah Sampul Dokumen</div>
                        <input type="file" class="image-preview-filepond" name="cover_image" id="documents_cover_image_update">
                        @error('cover_image')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_cover_image_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_title_update">Judul</label>
                        <input type="text" class="form-control" id="documents_title_update" name="title" value="{{ old('title', $document->title) }}" placeholder="Masukkan Nama">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_title_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_slug_update">Slug</label>
                        <input type="text" class="form-control" name="slug" id="documents_slug_update" value="{{ old('slug', $document->slug) }}" readonly placeholder="Masukkan Slug">
                        @error('slug')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_slug_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_description_update">Deskripsi</label>
                        <textarea name="description" id="summernote">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_description_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_document_category_update">Kategori</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="document_category_id" id="documents_document_category_id_update" value="{{ old('document_category_id') }}">
                            </select>
                        </fieldset>
                        @error('document_category_id')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_document_category_id_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_file_update">Dokumen (Dapat Lebih Dari Satu Dokumen)</label>
                        <div class="text-warning mt-2" role="alert">Kosongkan Jika Tidak Ingin Menambah Dokumen | Masukkan Jika Ingin Menambah Dokumen | Wajib Menambahkan Dokumen Jika Tidak Terdapat Dokumen Sama Sekali</div>
                        <input type="file" class="multiple-files-filepond" name="file[]" id="alert_documents_file_update">
                        @error('file')
                        <div class="text-danger mt-2" role="alert" id="alert_documents_file_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_is_announcement_update">Pengumuman</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_announcement" id="documents_is_announcement_update" value="{{ old('is_announcement', $document->is_announcement) }}">
                            </select>
                        </fieldset>
                        @error('is_announcement')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_is_announcement_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_is_active_update">Aktif</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_active" id="documents_is_active_update" value="{{ old('is_active', $document->is_active) }}">
                            </select>
                        </fieldset>
                        @error('is_active')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_is_active_update">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="documentagenda_update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Ubah</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Hapus File Dokumen</h4>
            </div>
            <div class="card-body">
                @if (count($document->document_files) > 0)
                    @foreach ($document->document_files as $df)
                        <div class="list-group">
                            <a href="{{ Storage::url($df->file) }}" target="_blank" class="list-group-item list-group-item-action my-1">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $df->file_name }}</h5>
                                    <form action="{{ url('/admin/documents/'. $df->id . '/delete-file') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </div>
                                <small>Klik Untuk Lihat atau Unduh</small>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mb-3">Dokumen Tidak Ditemukan</p>
                @endif
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Sampul Dokumen</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/'.$document->document_cover_images->image) }}">
                        </div>
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
    var documentsDocumentCategoryEditDropdown = null;

    $('#documents_title_update').on('keyup', function() {
        $.ajax({
            url: '/admin/documents/check-slug',
            type: 'GET',
            data: {title: $(this).val()},
            dataType: 'json',
            success: function(data) {
                $('#documents_slug_update').val(data.slug);
            },
            error: function(error) {
                console.error('Error checking slug:', error);
            }
        });
    });

    $(document).ready(function(){
        documentsIsAnnouncementCreateDropdown = new Choices('#documents_is_announcement_update', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Dokumen',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        documentsIsAnnouncementCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldIsAnnouncement = "{{ old('is_announcement', $document->is_announcement) }}";
                var oldValue = parseInt(oldIsAnnouncement);

                var choices = [
                    { label: 'Ya', value: 1 },
                    { label: 'Tidak', value: 0 },
                ];

                if (oldIsAnnouncement) {
                    choices.forEach(function(choice) {
                        if (choice.value === oldValue) {
                            choice.selected = true;
                        }
                    });
                } else {
                    choices.forEach(function(choice) {
                        if (choice.value === 0) {
                            choice.selected = true;
                        }
                    });
                }

                resolve(choices);
            });
        }, 'value', 'label', true);

        documentsIsActiveCreateDropdown = new Choices('#documents_is_active_update', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Dokumen',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        documentsIsActiveCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldIsActive = "{{ old('is_active', $document->is_active) }}";
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

        documentsDocumentCategoryCreateDropdown = new Choices('#documents_document_category_id_update', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Berita'
        });

        documentsDocumentCategoryCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-document-category-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('document_category_id', $document->document_category_id) }}";

                    choices.forEach(function(choice) {
                        if (choice.value == oldValue) {
                            choice.selected = true;
                        }
                    });

                    resolve(choices);
                }).fail(reject);
            });
        }, 'value', 'label', true);
    });
</script>
@endsection
