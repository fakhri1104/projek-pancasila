<?php

namespace App\Models\Siswas;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'nisn',
        'kelas',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function getAuthPasswordName()
    {
        return 'kata_sandi';
    }

    /**
     * Relasi ke aspirasi siswa
     */
    public function aspirasis()
    {
        return $this->hasMany(\App\Models\Aspirasi::class, 'siswa_id');
    }
    
}
