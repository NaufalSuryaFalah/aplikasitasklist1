@extends('layouts.master')

@section('title', 'Daftar Task Order')
@section('header', 'Daftar Task Order')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalTasks }}</h3>
                    <p>Total Tugas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $statusCounts['pending'] ?? 0 }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-start"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $statusCounts['proses'] ?? 0 }}</h3>
                    <p>Proses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $statusCounts['selesai'] ?? 0 }}</h3>
                    <p>Selesai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title">Semua Task Order</h3>
                <div class="btn-group btn-group-sm ml-3" role="group">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary {{ empty($status) ? 'active' : '' }}">Semua</a>
                    @foreach($statuses as $key => $label)
                        <a href="{{ route('tasks.index', ['status' => $key]) }}" class="btn btn-outline-secondary {{ $status === $key ? 'active' : '' }}">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Tugas</a>
            @endif
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($status)
                <div class="alert alert-info">Menampilkan tugas dengan status <strong>{{ $statuses[$status] ?? ucfirst($status) }}</strong>.</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Deskripsi Tugas</th>
                            <th>Status</th>
                            <th>Tgl Input</th>
                            <th>Tgl Selesai</th>
                            <th>Admin</th>
                            <th>Teknisi</th>
                            <th style="width: 160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($taskOrders as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->deskripsi_tugas }}</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge badge-warning',
                                            'proses' => 'badge badge-info',
                                            'selesai' => 'badge badge-success',
                                        ];
                                    @endphp
                                    <span class="{{ $statusClasses[$task->status] ?? 'badge badge-secondary' }}">{{ ucfirst($task->status) }}</span>
                                </td>
                                <td>{{ optional($task->tgl_input)->format('Y-m-d') }}</td>
                                <td>{{ optional($task->tgl_selesai)->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $task->admin?->name ?? 'Tidak ada admin' }}</td>
                                <td>{{ $task->teknisi?->name ?? '-' }}</td>
                                <td>
                                    @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'teknisi' && $task->id_teknisi === auth()->id()))
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Ubah</a>
                                    @endif

                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus tugas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->role === 'teknisi' && $task->status === 'pending' && ! $task->id_teknisi)
                                        <form action="{{ route('tasks.claim', $task) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Klaim tugas ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Klaim</button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->role === 'teknisi' && $task->status === 'proses' && $task->id_teknisi === auth()->id())
                                        <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Selesaikan tugas ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-flag-checkered"></i> Selesaikan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada task order. Silakan tambahkan tugas baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
