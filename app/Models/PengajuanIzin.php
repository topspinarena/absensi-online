<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis',
        'alasan',
        'lampiran',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}