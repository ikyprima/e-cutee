<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_cuti_persetujuan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ajukan_cuti');
            $table->bigInteger('id_detail_hirarki');
            $table->char('status', 1)->default(0); // setujui atau tolak
            $table->char('aktif', 1)->default(0); // aktif posisi persetujuan saat ini
            $table->bigInteger('id_pegawai')->nullable();
            $table->text('alasan_tolak')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_cuti_persetujuan');
    }
};
