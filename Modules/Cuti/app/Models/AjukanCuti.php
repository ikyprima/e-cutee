<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\AjukanCutiFactory;
use Modules\Cuti\Models\AjukanCutiTanggal;
use Modules\Cuti\Models\AjukanCutiPersetujuan;
use Modules\Cuti\Models\JenisCuti;
use Modules\Pegawai\Models\ModelPegawai;
class AjukanCuti extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_ajukan';
    protected $fillable = ['id_jenis_cuti','alasan_cuti','alamat','telp','id_pegawai'];

    protected static function newFactory(): AjukanCutiFactory
    {
        //return AjukanCutiFactory::new();
    }
    function detailTanggal(){
        return $this->hasMany(AjukanCutiTanggal::class,'id_ajukan_cuti','id');
    }
    function detailPersetujuan(){
        return $this->hasMany(AjukanCutiPersetujuan::class,'id_ajukan_cuti','id');
    }
    function jenisCuti(){
        return $this->hasOne(JenisCuti::class,'id','id_jenis_cuti');
    }
    
    function pegawai(){
        return $this->hasOne(ModelPegawai::class,'id','id_pegawai');
    }
}
