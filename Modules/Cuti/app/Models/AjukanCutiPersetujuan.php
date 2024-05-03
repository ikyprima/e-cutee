<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\AjukanCutiPersetujuanFactory;
use Modules\Cuti\Models\DetailHirarki;
use Modules\Cuti\Models\AjukanCuti;
use Modules\Pegawai\Models\ModelPegawai;
class AjukanCutiPersetujuan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_persetujuan';
    protected $fillable = ['id_ajukan_cuti','id_detail_hirarki','status','id_pegawai','aktif'];

    protected static function newFactory(): AjukanCutiPersetujuanFactory
    {
        //return AjukanCutiPersetujuanFactory::new();
    }

    function dethirarki(){
        return $this->hasOne(DetailHirarki::class,'id','id_detail_hirarki');
    }
    function pegawai(){
        return $this->hasOne(ModelPegawai::class,'id','id_pegawai');
    }
    function masterajukancuti(){
        return $this->hasOne(AjukanCuti::class, 'id','id_ajukan_cuti');
    }
    
}
