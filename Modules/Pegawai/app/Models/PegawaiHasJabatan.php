<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\PegawaiHasJabatanFactory;
use Modules\Pegawai\Models\ModelJabatan;
class PegawaiHasJabatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id_pegawai','id_jabatan'];
    protected $table = 'tb_pegawai_has_jabatan';
    public $incrementing = false;

    
    public $timestamps = false;
    protected static function newFactory(): PegawaiHasJabatanFactory
    {
        //return PegawaiHasJabatanFactory::new();
    }
    public function jabatan(){
        return $this->hasOne(ModelJabatan::class,'id','id_jabatan');
    }
   
}
