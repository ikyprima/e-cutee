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
        Schema::create('tb_lampiran_ajukan_cuti', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_cuti_ajukan'); //id tb_cuti_ajukan
            $table->string('path');
            $table->string('nama_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lampiran_ajukan_cuti');
    }
};
