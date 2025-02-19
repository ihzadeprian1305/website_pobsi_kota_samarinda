@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Handicap/Klasemen/Klasemen</h3>
                <p class="text-subtitle text-muted">Daftar Data Handicap/Klasemen/Klasemen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item">Data Master</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Handicap/Klasemen/Klasemen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/standings/create') }}" class="btn btn-primary mb-2" id="btn-create-users">Tambah</a>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <table class="table" id="table_standings">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Handicap/Klasemen/Klasemen</th>
                            <th>Total Poin</th>
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
        $('#table_standings').DataTable({
            processing: true,
            serverSide: true,
            ajax: `/admin/standings`,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: false,},
                {data: 'handicap', name: 'handicap', orderable: false,},
                {data: 'total_points', name: 'total_points', orderable: false,},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection
