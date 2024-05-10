<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\ModelJabatanFactory;

class ModelJabatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'tb_jabatan';
    protected static function newFactory(): ModelJabatanFactory
    {
        //return ModelJabatanFactory::new();
    }
}
