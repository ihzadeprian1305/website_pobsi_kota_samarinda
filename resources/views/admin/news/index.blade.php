@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Postingan Berita</h3>
                <p class="text-subtitle text-muted">Daftar Postingan Berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item">Postingan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Berita</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/news/create') }}" class="btn btn-primary mb-2" id="btn-create-news">Tambah</a>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <table class="table" id="table_news">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            {{-- <th>Ringkasan</th>
                            <th>Ditulis Oleh</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#table_news').DataTable({
            processing: true,
            serverSide: true,
            ajax: `/admin/news`,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                // {data: 'excerpt', name: 'excerpt'},
                // {data: 'created_by', name: 'created_by'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection
