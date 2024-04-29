<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\JenisCutiFactory;

class JenisCuti extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'tb_jenis_cuti';
    protected $fillable = [];

    protected static function newFactory(): JenisCutiFactory
    {
        //return JenisCutiFactory::new();
    }
}
