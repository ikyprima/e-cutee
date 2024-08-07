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
        Schema::create('tb_ajukan_dokumen_output', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi_file')->nullable();
            $table->bigInteger('id_cuti_ajukan'); //id tb_cuti_ajukan
            $table->string('path');
            $table->string('nama_file');
            $table->char('jenis_file',1); //1 = blanko 2=surat izin 
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('');
    }
};
