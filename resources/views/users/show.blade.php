@extends('layouts.master')

@section('title', 'Detail User')
@section('header', 'Detail User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Detail User</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID</label>
                        <p class="form-control-plaintext">{{ $user->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <p class="form-control-plaintext">{{ $user->username }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <p class="form-control-plaintext">{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <p class="form-control-plaintext">
                            @if ($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-info">Teknisi</span>
                            @endif
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
