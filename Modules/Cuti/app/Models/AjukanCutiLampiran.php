<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\AjukanCutiLampiranFactory;

class AjukanCutiLampiran extends Model
{
    use HasFactory;

    protected $table = "tb_lampiran_ajukan_cuti";
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id_cuti_ajukan','path','nama_file'];
    

    protected static function newFactory(): AjukanCutiLampiranFactory
    {
        //return AjukanCutiLampiranFactory::new();
    }
}
