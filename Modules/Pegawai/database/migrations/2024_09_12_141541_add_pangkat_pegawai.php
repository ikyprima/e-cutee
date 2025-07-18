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
        Schema::table('tb_pegawai', function (Blueprint $table) {
            $table->string(column: 'nama_pangkat')->nullable()->after('id_jabatan_organisasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_pegawai', function (Blueprint $table) {
            $table->string('nama_pangkat');
        });
    }
};
