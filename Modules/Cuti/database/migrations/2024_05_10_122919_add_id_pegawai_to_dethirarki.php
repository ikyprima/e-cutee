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
        Schema::table('tb_cuti_det_hirarki', function (Blueprint $table) {
            $table->bigInteger('id_pegawai')->after('id_jabatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_cuti_det_hirarki', function (Blueprint $table) {
            $table->dropColumn('id_pegawai');
        });
    }
};
