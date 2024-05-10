<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\PegawaiFactory;
use Modules\Jabatan\Models\JabatanOrganisasi;
class Pegawai extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "tb_pegawai";
    protected $fillable = [];

    protected static function newFactory(): PegawaiFactory
    {
        //return PegawaiFactory::new();
    }

    function jabatanOrganisasi(){
        return $this->hasOne(JabatanOrganisasi::class,'id','id_jabatan_organisasi');
    }
}
