<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasis';

    protected $fillable = [
        'siswa_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi',
        'status',
        'respon_admin',
        'tanggal_kirim',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Status constants
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    public static function getStatusList()
    {
        return [
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
        ];
    }

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswas\Siswa::class, 'siswa_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function fotoPengaduan()
    {
        return $this->hasMany(FotoPengaduan::class, 'aspirasi_id');
    }

    public function riwayatStatus()
    {
        return $this->morphMany(RiwayatStatus::class, 'laporan')->orderBy('created_at', 'desc');
    }

    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', self::STATUS_DIPROSES);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    // Helper methods
    public function isMenunggu()
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    public function isDiproses()
    {
        return $this->status === self::STATUS_DIPROSES;
    }

    public function isSelesai()
    {
        return $this->status === self::STATUS_SELESAI;
    }

    public function isDitolak()
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DIPROSES => 'bg-blue-100 text-blue-800',
            self::STATUS_SELESAI => 'bg-green-100 text-green-800',
            self::STATUS_DITOLAK => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
