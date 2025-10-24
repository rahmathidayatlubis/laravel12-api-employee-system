<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Alumni extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'alumni';

    protected $fillable = [
        'nim',
        'nama_lengkap',
        'email',
        'password',
        'no_telepon',
        'tahun_masuk',
        'tahun_lulus',
        'jurusan',
        'program_studi',
        'ipk',
        'status_pekerjaan',
        'nama_perusahaan',
        'posisi_pekerjaan',
        'bidang_pekerjaan',
        'gaji_range',
        'alamat_lengkap',
        'kota',
        'provinsi',
        'linkedin_url',
        'instagram_username',
        'catatan',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer',
        'ipk' => 'decimal:2',
        'gaji_range' => 'decimal:2',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Scope untuk filter
    public function scopeFilterByTahunLulus($query, $tahun)
    {
        return $query->where('tahun_lulus', $tahun);
    }

    public function scopeFilterByStatusPekerjaan($query, $status)
    {
        return $query->where('status_pekerjaan', $status);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_lengkap', 'like', "%{$keyword}%")
                ->orWhere('nim', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('nama_perusahaan', 'like', "%{$keyword}%");
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
