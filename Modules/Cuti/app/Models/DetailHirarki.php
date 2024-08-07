<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\DetailHirarkiFactory;
use Modules\Pegawai\Models\PegawaiHasJabatan;
use Modules\Pegawai\Models\Pegawai;
use Illuminate\Database\Eloquent\SoftDeletes;
class DetailHirarki extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     */
    protected $table ='tb_cuti_det_hirarki';
    protected $dates = ['deleted_at'];

    protected $fillable = ['id_hirarki','urutan','id_jabatan','id_pegawai'];

    protected static function newFactory(): DetailHirarkiFactory
    {
        //return DetailHirarkiFactory::new();
    }
    public function pegawaiByJabatan(){
        return $this->hasOne(PegawaiHasJabatan::class,'id_jabatan','id_jabatan');
    }
    public function pegawai(){
        return $this->hasOne(Pegawai::class,'id','id_pegawai');
    }
}
