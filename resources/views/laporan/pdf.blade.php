<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Task Order</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Task Order Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th>Deskripsi</th>
                <th>Tenggat Waktu</th>
                <th>Teknisi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->deskripsi_tugas }}</td>
                <td>{{ $task->tgl_selesai ? $task->tgl_selesai->format('Y-m-d') : '-' }}</td>
                <td>{{ $task->teknisi?->name ?? '-' }}</td>
                <td>{{ $task->catatan_hasil ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
