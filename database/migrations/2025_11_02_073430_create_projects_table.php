<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            $table->string('nama_proyek');
            $table->string('kategori_proyek')->nullable(); // Website, Mobile, IoT, ERP, dll
            $table->text('deskripsi_proyek')->nullable();
            $table->text('fitur_utama')->nullable();
            $table->string('teknologi_digunakan')->nullable(); // "Laravel, Flutter, Firebase"
            $table->string('status_proyek')->default('Draft'); // Draft, On Progress, Testing, Selesai, Maintenance

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->decimal('nilai_proyek', 15, 2)->nullable();
            $table->string('url_demo')->nullable();
            $table->string('repo_url')->nullable();

            $table->string('gambar_proyek')->nullable(); // path file
            $table->text('catatan_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('projects');
    }
};
