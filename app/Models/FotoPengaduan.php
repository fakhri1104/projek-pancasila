<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPengaduan extends Model
{
    use HasFactory;

    protected $table = 'foto_pengaduan';

    protected $fillable = [
        'aspirasi_id',
        'url_foto'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    // Accessor untuk full URL
    public function getFullUrlAttribute()
    {
        return asset($this->url_foto);
    }
}
