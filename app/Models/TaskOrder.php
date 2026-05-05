<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskOrder extends Model
{
    protected $fillable = [
        'deskripsi_tugas',
        'status',
        'tgl_input',
        'tgl_selesai',
        'catatan_hasil',
        'id_admin',
        'id_teknisi',
    ];

    protected $casts = [
        'tgl_input' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_teknisi');
    }
}
