@extends('layouts.master')

@section('title', 'Tambah Task Order')
@section('header', 'Tambah Task Order')

@section('content')
    <div class="card">
        <div class="card-body">
            @include('tasks.form', [
                'action' => route('tasks.store'),
                'method' => 'POST',
                'buttonLabel' => 'Simpan Tugas',
            ])
        </div>
    </div>
@endsection
