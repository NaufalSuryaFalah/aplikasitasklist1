@extends('layouts.master')

@section('title', 'Daftar Laporan')
@section('header', 'Daftar Laporan')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Laporan Task</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('laporan.pdf') }}" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Deskripsi</th>
                            <th>Tenggat Waktu</th>
                            <th>Teknisi</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tasks = \App\Models\TaskOrder::with(['teknisi'])->whereMonth('tgl_input', now()->month)->whereYear('tgl_input', now()->year)->get();
                        @endphp
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->deskripsi_tugas }}</td>
                                <td>{{ $task->tgl_selesai ? $task->tgl_selesai->format('Y-m-d') : '-' }}</td>
                                <td>{{ $task->teknisi?->name ?? '-' }}</td>
                                <td>{{ $task->catatan_hasil ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                            <td colspan="5" class="text-center">Belum ada tugas order bulan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
