@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Berita</h3>
                <p class="text-subtitle text-muted">Lihat Data Berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/news">Data Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lihat</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Lihat Berita</h4>
            </div>
            <div class="card-body">
                @if ($news->news_cover_images->image)
                    <div class="row gallery">
                        <div class="mx-auto d-block col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                            <a href="#" class="thumbnail" data-bs-slide-to="1" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                <img class="w-100" src="{{ asset('storage/'. $news->news_cover_images->image) }}">
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center">Foto Tidak Ditemukan</p>
                @endif
                <div class="form-group">
                    <label for="news_title_show">Judul</label>
                    <input type="text" class="form-control" name="title" id="news_title_show" value="{{ $news->title }}" disabled>
                </div>
                <div class="form-group">
                    <label for="news_slug_show">Slug</label>
                    <input type="text" class="form-control" name="slug" id="news_slug_show" value="{{ $news->slug }}" disabled>
                </div>
                <div class="form-group">
                    <label for="news_content_show">Isi Berita</label>
                    <textarea name="content" id="news_content_show" disabled>{{ $news->content }}</textarea>
                </div>
                <div class="form-group">
                    <label for="news_news_category_id_show">Kategori</label>
                    <input type="text" class="form-control" name="news_category_id" id="news_news_category_id_show" value="{{ $news->news_categories->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="news_news_tag_id_create">Tag</label>
                    <fieldset class="form-group">
                        <select class="form-select multiple" name="news_tag_id" id="news_news_tag_id_create" multiple="multiple">
                        </select>
                    </fieldset>
                </div>
                <div class="form-group">
                    <label for="news_created_by_show">Dibuat Oleh</label>
                    <input type="text" class="form-control" name="created_by" id="news_created_by_show" value="{{ $news->user_created_by->user_data->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="news_posted_by_show">Diunggah Oleh</label>
                    <input type="text" class="form-control" name="posted_by" id="news_posted_by_show" value="{{ $news->user_posted_by->user_data->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="news_is_active_show">Aktif</label>
                    <input type="text" class="form-control" name="is_active" id="news_is_active_show" value="{{ $news->is_active ? 'Ya' : 'Tidak' }}" disabled>
                </div>
                <div class="form-group">
                    <label for="newss_image_show">Foto Berita</label>
                    @if (count($news->news_images) > 0)
                        <div class="row gallery">
                            @foreach($news->news_images as $ni)
                                <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-2 mb-md-2 mb-2">
                                    <a href="#" class="thumbnail" data-bs-slide-to="{{ $loop->index + 1 }}" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                        <img class="w-100" src="{{ asset('storage/'.$ni->image) }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Foto Tidak Ditemukan</p>
                    @endif
                </div>
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
                                data-bs-slide-to="1"
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
    var newsNewsTagCreateDropdown = null;

    $(document).ready(function () {
    newsNewsTagCreateDropdown = new Choices('#news_news_tag_id_create', {
        allowHTML: true,
        removeItems: false,
        removeItemButton: false,
        searchEnabled: false,
        searchChoices: false,
        noChoicesText: '',
    });

    newsNewsTagCreateDropdown.setChoices(function() {
        return new Promise(function(resolve, reject) {
            var data = <?php echo json_encode($news->news_tags->toArray()); ?>;

            var choices = data.map(function(tag) {
                return {
                    label: tag.name,
                    value: tag.id,
                };
            });

            resolve(choices);
        });
    }, 'value', 'label', true).then(function() {
        var allValues = <?php echo json_encode($news->news_tags->pluck('id')->toArray()); ?>;
        newsNewsTagCreateDropdown.setChoiceByValue(allValues);
        document.querySelector('.choices').disabled = true;
        document.querySelector('.choices__list--dropdown').style.display = 'none';
    });

    $('#news_content_show').summernote({
        toolbar: [],
        height: 300,
        minHeight: null,
        maxHeight: null,
        disableDragAndDrop: true,
        code: `{!! $news->content !!}`
    }).summernote('disable');
});
</script>
@endsection
