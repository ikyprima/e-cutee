<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\AjukanCutiPersetujuanFactory;

class AjukanCutiPersetujuan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_persetujuan';
    protected $fillable = ['id_ajukan_cuti','id_detail_hirarki','status','id_pegawai'];

    protected static function newFactory(): AjukanCutiPersetujuanFactory
    {
        //return AjukanCutiPersetujuanFactory::new();
    }
}
