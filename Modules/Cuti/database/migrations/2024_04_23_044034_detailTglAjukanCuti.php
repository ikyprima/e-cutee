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
        Schema::create('tb_cuti_detail_tgl_ajukan_cuti', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ajukan_cuti');
            $table->string('title');
            $table->string('tgl');
            $table->string('color');
            $table->char('status', 1)->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_cuti_detail_tgl_ajukan_cuti');
    }
};
