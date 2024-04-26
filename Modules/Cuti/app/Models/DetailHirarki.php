<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\DetailHirarkiFactory;
use Modules\Pegawai\Models\PegawaiHasJabatan;

class DetailHirarki extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table ='tb_cuti_det_hirarki';
    protected $fillable = [];

    protected static function newFactory(): DetailHirarkiFactory
    {
        //return DetailHirarkiFactory::new();
    }
    public function pegawaiByJabatan(){
        return $this->hasOne(PegawaiHasJabatan::class,'id_jabatan','id_jabatan');
    }
}
