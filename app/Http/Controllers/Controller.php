<?php

namespace App\Http\Controllers;

use App\Models\TaskOrder;

abstract class Controller
{
    protected function user()
    {
        return auth()->user();
    }

    protected function authorizeRole(string $role): void
    {
        if (! $this->user() || $this->user()->role !== $role) {
            abort(403);
        }
    }

    protected function authorizeRoles(array $roles): void
    {
        if (! $this->user() || ! in_array($this->user()->role, $roles, true)) {
            abort(403);
        }
    }

    protected function authorizeTaskForTeknisi(TaskOrder $task): void
    {
        if ($this->user()->role !== 'teknisi' || $task->id_teknisi !== $this->user()->id) {
            abort(403);
        }
    }
}
