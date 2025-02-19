@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Dokumen</h3>
                <p class="text-subtitle text-muted">Tambah Data Dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/documents">Data Dokumen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Dokumen</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-danger">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <form action="{{ url('/admin/documents') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="documents_cover_image_create">Sampul Dokumen</label>
                        <input type="file" class="image-preview-filepond" name="cover_image" id="documents_cover_image_create">
                        @error('cover_image')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_cover_image_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_title_create">Judul</label>
                        <input type="text" class="form-control" id="documents_title_create" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul">
                        @error('title')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_title_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_slug_create">Slug</label>
                        <input type="text" class="form-control" name="slug" id="documents_slug_create" value="{{ old('slug') }}" readonly placeholder="Masukkan Slug">
                        @error('slug')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_slug_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_description_create">Deskripsi</label>
                        <textarea name="description" id="summernote">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_description_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_document_category_create">Kategori</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="document_category_id" id="documents_document_category_id_create" value="{{ old('document_category_id') }}">
                            </select>
                        </fieldset>
                        @error('document_category_id')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_document_category_id_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_file_create">Dokumen (Dapat Lebih Dari Satu Dokumen)</label>
                        <input type="file" class="multiple-files-filepond" name="file[]" id="alert_documents_file_create">
                        @error('file')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_file_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_is_announcement_create">Pengumuman</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_announcement" id="documents_is_announcement_create" value="{{ old('is_announcement') }}">
                            </select>
                        </fieldset>
                        @error('is_announcement')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_is_announcement_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="documents_is_active_create">Aktif</label>
                        <fieldset class="form-group">
                            <select class="form-select" name="is_active" id="documents_is_active_create" value="{{ old('is_active') }}">
                            </select>
                        </fieldset>
                        @error('is_active')
                            <div class="text-danger mt-2" role="alert" id="alert_documents_is_active_create">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ml-1 float-end" id="submit_btn_documents_create">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class=" d-sm-block">Tambah</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    var documentsSexCreateDropdown = null;

    $('#documents_title_create').on('keyup', function() {
        $.ajax({
            url: '/admin/documents/check-slug',
            type: 'GET',
            data: {title: $(this).val()},
            dataType: 'json',
            success: function(data) {
                $('#documents_slug_create').val(data.slug);
            },
            error: function(error) {
                console.error('Error checking slug:', error);
            }
        });
    });

    $(document).ready(function(){
        documentsIsAnnouncementCreateDropdown = new Choices('#documents_is_announcement_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Dokumen',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        documentsIsAnnouncementCreateDropdown.setChoices(function() {
            return new Promise(function(resolve) {
                var oldIsAnnouncement = "{{ old('is_announcement') }}";
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

        documentsIsActiveCreateDropdown = new Choices('#documents_is_active_create', {
            allowHTML: true,
            searchEnabled: false,
            placeholderValue: 'Pilih Keaktifan Dokumen',
            sorter: function(a, b) {
                return a.label.length - b.label.length;
            },
        });

        documentsIsActiveCreateDropdown.setChoices(function() {
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

        documentsDocumentCategoryCreateDropdown = new Choices('#documents_document_category_id_create', {
            allowHTML: true,
            searchPlaceholderValue: 'Cari',
            placeholderValue: 'Pilih Kategori Dokumen'
        });

        documentsDocumentCategoryCreateDropdown.setChoices(function() {
            return new Promise(function(resolve, reject) {
                $.get('/admin/get-values/get-document-category-dropdown-values', function(data) {
                    var choices = [];
                    $.each(data, function(key, value) {
                        choices.push({ label: value, value: key });
                    });

                    var oldValue = "{{ old('document_category_id') }}";

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
