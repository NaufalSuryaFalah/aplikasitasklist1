@extends('layouts.master')

@section('title', 'Dashboard')
@section('header', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalTasks }}</h3>
                <p>Total Task</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
            <a href="{{ route('tasks.index') }}" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingTasks }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-start"></i>
            </div>
            <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $prosesTasks }}</h3>
                <p>Proses</p>
            </div>
            <div class="icon">
                <i class="fas fa-spinner"></i>
            </div>
            <a href="{{ route('tasks.index', ['status' => 'proses']) }}" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $selesaiTasks }}</h3>
                <p>Selesai</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('tasks.index', ['status' => 'selesai']) }}" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Task Terbaru</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Admin</th>
                            <th>Teknisi</th>
                            <th>Tgl Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->deskripsi_tugas }}</td>
                                <td>
                                    <span class="badge badge-{{ $task->status === 'pending' ? 'warning' : ($task->status === 'proses' ? 'info' : 'success') }}">{{ ucfirst($task->status) }}</span>
                                </td>
                                <td>{{ $task->admin?->name ?? '-' }}</td>
                                <td>{{ $task->teknisi?->name ?? '-' }}</td>
                                <td>{{ optional($task->tgl_input)->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada task terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection