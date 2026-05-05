@extends('layouts.auth')

@section('title', 'Daftar Task List')

@section('body')
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Task</b>List</a>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Daftar akun baru</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user-circle"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select name="role" class="form-control" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="teknisi" {{ old('role') === 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                </div>
            </form>

            <p class="mt-3">
                <a href="{{ route('login') }}" class="text-center">Sudah punya akun? Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
