<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status';

    protected $fillable = [
        'laporan_id',
        'laporan_type',
        'admin_id',
        'status',
        'umpan_balik',
        'keterangan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Status constants
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    /**
     * Get the parent laporan model (Aspirasi or Pengaduan)
     */
    public function laporan()
    {
        return $this->morphTo();
    }

    /**
     * Get the admin who made this status update
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\Admins\Admin::class, 'admin_id');
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get formatted created date
     */
    public function getTanggalUmpanBalikAttribute()
    {
        return $this->created_at->format('d F Y H:i');
    }
}
