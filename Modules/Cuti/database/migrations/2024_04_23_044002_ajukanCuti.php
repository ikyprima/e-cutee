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
        Schema::create('tb_cuti_ajukan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jenis_cuti');
            $table->string('alasan_cuti'); 
            $table->longText('alamat'); 
            $table->string('telp',12); 
            $table->bigInteger('id_pegawai');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_cuti_ajukan');
    }
};
