@extends('layouts.master')

@section('title', 'Tambah Laporan')
@section('header', 'Tambah Laporan')

@section('content')
    <div class="card">
        <div class="card-body">
            @include('laporan.form', [
                'action' => route('laporan.store'),
                'method' => 'POST',
                'buttonLabel' => 'Simpan Laporan',
                'tgl_cetak' => $tgl_cetak ?? null,
                'periode_laporan' => $periode_laporan ?? null,
                'total_tugas' => $total_tugas ?? null,
            ])
        </div>
    </div>
@endsection
