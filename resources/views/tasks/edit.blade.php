@extends('layouts.master')

@section('title', 'Ubah Task Order')
@section('header', 'Ubah Task Order')

@section('content')
    <div class="card">
        <div class="card-body">
            @include('tasks.form', [
                'action' => route('tasks.update', $taskOrder),
                'method' => 'PUT',
                'buttonLabel' => 'Perbarui Tugas',
            ])
        </div>
    </div>
@endsection
