@extends('admin.layouts.app')
@section('container')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengguna</h3>
                <p class="text-subtitle text-muted">Daftar Data Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/users/create') }}" class="btn btn-primary mb-2" id="btn-create-users">Tambah</a>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            {!! session()->get('status') !!}
                        </div>
                    </div>
                @endif
                <table class="table" id="table-users">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
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
        $('#table-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: `/admin/users`,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'username', name: 'username'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection
