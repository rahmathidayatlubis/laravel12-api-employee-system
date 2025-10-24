<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $statusPekerjaan = ['bekerja', 'wirausaha', 'melanjutkan_studi', 'mencari_kerja', 'lainnya'];
        $jurusan = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Manajemen'];
        $kota = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang'];

        for ($i = 1; $i <= 10; $i++) {
            $tahunMasuk = rand(2015, 2020);
            $tahunLulus = $tahunMasuk + 4;
            $status = $statusPekerjaan[array_rand($statusPekerjaan)];

            Alumni::create([
                'nim' => '2020' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'nama_lengkap' => 'Alumni ' . $i,
                'email' => 'alumni' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'tahun_masuk' => $tahunMasuk,
                'tahun_lulus' => $tahunLulus,
                'jurusan' => $jurusan[array_rand($jurusan)],
                'program_studi' => 'S1',
                'ipk' => rand(250, 400) / 100,
                'status_pekerjaan' => $status,
                'nama_perusahaan' => $status === 'bekerja' ? 'PT. Company ' . $i : null,
                'posisi_pekerjaan' => $status === 'bekerja' ? ['Staff', 'Manager', 'Developer', 'Analyst'][array_rand(['Staff', 'Manager', 'Developer', 'Analyst'])] : null,
                'bidang_pekerjaan' => $status === 'bekerja' ? ['IT', 'Finance', 'Marketing', 'Operations'][array_rand(['IT', 'Finance', 'Marketing', 'Operations'])] : null,
                'gaji_range' => $status === 'bekerja' ? rand(5000000, 20000000) : null,
                'alamat_lengkap' => 'Jl. Contoh No. ' . $i,
                'kota' => $kota[array_rand($kota)],
                'provinsi' => 'Jawa Barat',
                'linkedin_url' => 'https://linkedin.com/in/alumni' . $i,
                'instagram_username' => '@alumni' . $i,
                'catatan' => 'Alumni angkatan ' . $tahunLulus,
                'is_active' => true,
            ]);
        }
    }
}
