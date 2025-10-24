<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nim' => $this->nim,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'no_telepon' => $this->no_telepon,
            'akademik' => [
                'tahun_masuk' => $this->tahun_masuk,
                'tahun_lulus' => $this->tahun_lulus,
                'jurusan' => $this->jurusan,
                'program_studi' => $this->program_studi,
                'ipk' => (float) $this->ipk,
            ],
            'pekerjaan' => [
                'status' => $this->status_pekerjaan,
                'nama_perusahaan' => $this->nama_perusahaan,
                'posisi' => $this->posisi_pekerjaan,
                'bidang' => $this->bidang_pekerjaan,
                'gaji_range' => $this->gaji_range ? (float) $this->gaji_range : null,
            ],
            'alamat' => [
                'lengkap' => $this->alamat_lengkap,
                'kota' => $this->kota,
                'provinsi' => $this->provinsi,
            ],
            'social_media' => [
                'linkedin' => $this->linkedin_url,
                'instagram' => $this->instagram_username,
            ],
            'catatan' => $this->catatan,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}