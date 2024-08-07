<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\PersetujuanPimpinanFactory;

class PersetujuanPimpinan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "tb_persetujuan_kepala";
    protected $fillable = ['tanggal_persetujuan','keterangan','status','id_ajukan_cuti'];


    protected static function newFactory(): PersetujuanPimpinanFactory
    {
        //return PersetujuanPimpinanFactory::new();
    }
}
