<?php

namespace Modules\Kepala\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Kepala\Database\Factories\KepalaFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pegawai\Models\ModelPegawai;
class Kepala extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table= "tb_kepala";
    protected $fillable = ["id_pegawai","status"];

    protected $dates = ['deleted_at'];
    protected static function newFactory(): KepalaFactory
    {
        //return KepalaFactory::new();
    }
    public function pegawai(){
        return $this->hasOne(ModelPegawai::class,'id','id_pegawai');
    }
}
