<?php

namespace App\Http\Controllers;

use App\Models\TaskOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $statuses = [
            'pending' => 'Pending',
            'proses' => 'Proses',
            'selesai' => 'Selesai',
        ];

        $query = TaskOrder::with(['admin', 'teknisi'])->orderByDesc('created_at');

        if ($status && in_array($status, array_keys($statuses), true)) {
            $query->where('status', $status);
        }

        $taskOrders = $query->get();
        $statusCounts = TaskOrder::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();
        $totalTasks = TaskOrder::count();

        return view('tasks.index', compact('taskOrders', 'statusCounts', 'totalTasks', 'status', 'statuses'));
    }

    public function create()
    {
        $this->authorizeRole('admin');

        $admins = User::where('role', 'admin')->get();
        $teknicians = User::where('role', 'teknisi')->get();
        $currentAdminId = auth()->id();

        return view('tasks.create', compact('admins', 'teknicians', 'currentAdminId'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'deskripsi_tugas' => ['required', 'string'],
            'status' => ['required', Rule::in(['pending', 'proses', 'selesai'])],
            'catatan_hasil' => ['nullable', 'string'],
            'id_admin' => ['required', 'exists:users,id'],
            'id_teknisi' => ['nullable', 'exists:users,id'],
        ]);

        $data['tgl_input'] = now()->format('Y-m-d');

        if ($data['status'] === 'selesai') {
            $data['tgl_selesai'] = now()->format('Y-m-d');
        }

        TaskOrder::create($data);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit(TaskOrder $task)
    {
        if ($this->user()->role === 'teknisi') {
            $this->authorizeTaskForTeknisi($task);
        }

        $admins = User::where('role', 'admin')->get();
        $teknicians = User::where('role', 'teknisi')->get();

        return view('tasks.edit', [
            'taskOrder' => $task,
            'admins' => $admins,
            'teknicians' => $teknicians,
        ]);
    }

    public function update(Request $request, TaskOrder $task)
    {
        if ($this->user()->role === 'teknisi') {
            $this->authorizeTaskForTeknisi($task);

            $data = $request->validate([
                'status' => ['required', Rule::in(['pending', 'proses', 'selesai'])],
                'catatan_hasil' => ['nullable', 'string'],
            ]);

            if ($data['status'] === 'selesai') {
                $data['tgl_selesai'] = now()->format('Y-m-d');
            } elseif ($task->status === 'selesai' && $data['status'] !== 'selesai') {
                $data['tgl_selesai'] = null;
            }

            $task->update($data);
        } else {
            $data = $request->validate([
                'deskripsi_tugas' => ['required', 'string'],
                'status' => ['required', Rule::in(['pending', 'proses', 'selesai'])],
                'catatan_hasil' => ['nullable', 'string'],
                'id_admin' => ['required', 'exists:users,id'],
                'id_teknisi' => ['nullable', 'exists:users,id'],
            ]);

            if ($data['status'] === 'selesai') {
                $data['tgl_selesai'] = $task->tgl_selesai ?? now()->format('Y-m-d');
            } elseif ($task->status === 'selesai' && $data['status'] !== 'selesai') {
                $data['tgl_selesai'] = null;
            }

            $task->update($data);
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(TaskOrder $task)
    {
        $this->authorizeRole('admin');

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function claim(TaskOrder $task)
    {
        $this->authorizeRole('teknisi');

        if ($task->id_teknisi && $task->id_teknisi !== $this->user()->id) {
            abort(403);
        }

        if ($task->status !== 'pending') {
            return redirect()->route('tasks.index')->with('error', 'Hanya tugas pending yang bisa diklaim!');
        }

        $task->update([
            'id_teknisi' => $this->user()->id,
            'status' => 'proses',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diklaim.');
    }

    public function complete(TaskOrder $task)
    {
        $this->authorizeRole('teknisi');
        $this->authorizeTaskForTeknisi($task);

        if ($task->status !== 'proses') {
            return redirect()->route('tasks.index')->with('error', 'Hanya tugas yang sedang proses yang dapat diselesaikan!');
        }

        $task->update([
            'status' => 'selesai',
            'tgl_selesai' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diselesaikan.');
    }
}
