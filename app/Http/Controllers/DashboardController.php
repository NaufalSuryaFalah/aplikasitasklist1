<?php

namespace App\Http\Controllers;

use App\Models\TaskOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalTasks = TaskOrder::count();
        $pendingTasks = TaskOrder::where('status', 'pending')->count();
        $prosesTasks = TaskOrder::where('status', 'proses')->count();
        $selesaiTasks = TaskOrder::where('status', 'selesai')->count();
        $recentTasks = TaskOrder::with(['admin', 'teknisi'])->orderByDesc('created_at')->limit(5)->get();

        return view('dashboard', compact('totalTasks', 'pendingTasks', 'prosesTasks', 'selesaiTasks', 'recentTasks'));
    }
}
