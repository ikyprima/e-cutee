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
        Schema::create('tb_cuti_det_hirarki', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_hirarki');
            $table->integer('urutan');
            $table->bigInteger('id_jabatan');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_cuti_det_hirarki');
    }
};
