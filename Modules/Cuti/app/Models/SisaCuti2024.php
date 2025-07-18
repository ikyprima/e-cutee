<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\SisaCuti2024Factory;

class SisaCuti2024 extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_sisa_cuti_2024';
    protected $fillable = ['id_pegawai','sisa_cuti','tahun'];

    protected static function newFactory(): SisaCuti2024Factory
    {
        //return SisaCuti2024Factory::new();
    }
}
