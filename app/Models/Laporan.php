<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $fillable = [
        'tgl_cetak',
        'periode_laporan',
        'total_tugas',
        'id_admin',
    ];

    protected $casts = [
        'tgl_cetak' => 'date',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
