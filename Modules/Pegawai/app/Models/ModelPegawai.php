<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\ModelPegawaiFactory;
use Modules\Pegawai\Models\PegawaiHasUser;
class modelPegawai extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_pegawai';
    protected $fillable = [];

    protected static function newFactory(): ModelPegawaiFactory
    {
        //return ModelPegawaiFactory::new();
    }
    public function pegawai() {
        return $this->hasOne(PegawaiHasUser::class,'id_pegawai','id');
    }
}
