<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\AjukanCutiTanggalFactory;

class AjukanCutiTanggal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_detail_tgl_ajukan_cuti';
    protected $fillable = ['id_ajukan_cuti','title','tgl','color','status'];

    protected static function newFactory(): AjukanCutiTanggalFactory
    {
        //return AjukanCutiTanggalFactory::new();
    }
}
