<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientVisit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'menunggu' => ['label' => 'Menunggu Antrian', 'bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'dot' => 'bg-amber-500'],
            'sedang_diperiksa' => ['label' => 'Sedang Diperiksa', 'bg' => 'bg-indigo-100 text-indigo-800 border-indigo-200', 'dot' => 'bg-indigo-600 animate-pulse'],
            'farmasi' => ['label' => 'Pengambilan Obat', 'bg' => 'bg-cyan-100 text-cyan-800 border-cyan-200', 'dot' => 'bg-cyan-500'],
            'selesai' => ['label' => 'Selesai Konsultasi', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'dot' => 'bg-emerald-500'],
            'batal' => ['label' => 'Dibatalkan', 'bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'dot' => 'bg-rose-500'],
            default => ['label' => 'Status Tidak Diketahui', 'bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'dot' => 'bg-slate-400']
        };
    }
}
