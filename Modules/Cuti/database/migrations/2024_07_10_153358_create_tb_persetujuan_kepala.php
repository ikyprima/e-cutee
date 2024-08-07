<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * persetujuan kepala dinas atau kepala badan
     */
    public function up(): void
    {
        Schema::create('tb_persetujuan_kepala', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ajukan_cuti'); 
            $table->char('status',1)->default(0); // Kolom status
            $table->date('tanggal_persetujuan')->nullable(); // Kolom tanggal_persetujuan bisa null
            $table->text('keterangan')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_persetujuan_kepala');
    }
};
