<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_telepon', 20)->nullable();
            $table->year('tahun_masuk');
            $table->year('tahun_lulus');
            $table->string('jurusan');
            $table->string('program_studi');
            $table->decimal('ipk', 3, 2);

            // Status pekerjaan
            $table->enum('status_pekerjaan', [
                'bekerja',
                'wirausaha',
                'melanjutkan_studi',
                'mencari_kerja',
                'lainnya'
            ])->default('mencari_kerja');

            // Detail pekerjaan (optional)
            $table->string('nama_perusahaan')->nullable();
            $table->string('posisi_pekerjaan')->nullable();
            $table->string('bidang_pekerjaan')->nullable();
            $table->decimal('gaji_range', 12, 2)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kota');
            $table->string('provinsi');

            // Social media (optional)
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_username')->nullable();

            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk optimasi query
            $table->index('tahun_lulus');
            $table->index('status_pekerjaan');
            $table->index('jurusan');
            $table->index(['tahun_lulus', 'status_pekerjaan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};