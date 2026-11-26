<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PatientVisit::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_praktek) {
            'praktek' => 'Sedang Praktek',
            'istirahat' => 'Istirahat',
            'selesai' => 'Selesai',
            'belum_mulai' => 'Belum Mulai',
            'cuti' => 'Cuti',
            default => 'Tidak Aktif'
        };
    }
}
