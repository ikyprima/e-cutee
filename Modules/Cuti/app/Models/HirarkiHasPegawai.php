<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\HirarkiHasPegawaiFactory;
use Modules\Cuti\Models\Hirarki;
class HirarkiHasPegawai extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_hirarki_has_pegawai';
    protected $fillable = ['id_hirarki','id_pegawai'];
    
    protected static function newFactory(): HirarkiHasPegawaiFactory
    {
        //return HirarkiHasPegawaiFactory::new();
    }
    public function hirarki(){
        return $this->hasOne(Hirarki::class,'id','id_hirarki');
    }
}
