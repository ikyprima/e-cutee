<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\PegawaiHasUserFactory;
use Modules\Pegawai\Models\ModelPegawai;
class PegawaiHasUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'tb_pegawai_has_user';

    
    protected static function newFactory(): PegawaiHasUserFactory
    {
        //return PegawaiHasUserFactory::new();
    }
   
    public function pegawai() {
        return $this->hasOne(ModelPegawai::class,'id','id_pegawai');
    }
    
}
