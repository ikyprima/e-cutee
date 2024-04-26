<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\HirarkiFactory;
use Modules\Cuti\Models\DetailHirarki;

class Hirarki extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_cuti_hirarki';
    protected $fillable = [];

    protected static function newFactory(): HirarkiFactory
    {
        //return HirarkiFactory::new();
    }
    public function detailHirarki(){
        return $this->hasMany(DetailHirarki::class,'id_hirarki','id');
    }
}
