<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\ModelPegawaiFactory;
use Modules\Cuti\Models\HirarkiHasPegawai;
use Modules\Pegawai\Models\PegawaiHasJabatan;

class ModelPegawai extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_pegawai';
    protected $fillable = ['id_jabatan_organisasi','nomor_induk_pegawai','nama','tgl_lahir','id_jenis_kelamin','id_user_create'];

    protected static function newFactory(): ModelPegawaiFactory
    {
        //return ModelPegawaiFactory::new();
    }
    
    public function hasJabatan(){
        return $this->hasOne(PegawaiHasJabatan::class,'id_pegawai','id');
    }
    public function hasHirarki(){
        return $this->hasOne(HirarkiHasPegawai::class,'id_pegawai','id');
    }
   
}
