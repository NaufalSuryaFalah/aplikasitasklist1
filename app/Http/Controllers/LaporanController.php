<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use App\Models\TaskOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function exportPdf()
    {
        $this->authorizeRole('admin');
        $tasks = TaskOrder::with(['teknisi'])
            ->whereMonth('tgl_input', now()->month)
            ->whereYear('tgl_input', now()->year)
            ->get();
        $pdf = Pdf::loadView('laporan.pdf', compact('tasks'));
        return $pdf->stream('laporan-taskorder-'.now()->format('Ym').'.pdf');
    }
    public function index()
    {
        $this->authorizeRole('admin');

        $laporans = Laporan::with('admin')->orderByDesc('created_at')->get();

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        $this->authorizeRole('admin');

        $admins = User::where('role', 'admin')->get();

        // Otomatis tanggal cetak hari ini
        $tgl_cetak = now()->format('Y-m-d');

        // Otomatis periode laporan bulan berjalan (misal: April 2026)
        $periode_laporan = now()->translatedFormat('F Y');

        // Hitung total tugas bulan berjalan
        $total_tugas = \App\Models\TaskOrder::whereMonth('tgl_input', now()->month)
            ->whereYear('tgl_input', now()->year)
            ->count();

        return view('laporan.create', compact('admins', 'tgl_cetak', 'periode_laporan', 'total_tugas'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'tgl_cetak' => ['required', 'date'],
            'periode_laporan' => ['required', 'string'],
            'total_tugas' => ['required', 'integer', 'min:0'],
            'id_admin' => ['required', 'exists:users,id'],
        ]);

        Laporan::create($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function destroy(Laporan $laporan)
    {
        $this->authorizeRole('admin');

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}
