<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\DokumenOutputFactory;

class DokumenOutput extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = "tb_ajukan_dokumen_output";
    protected $fillable = ['deskripsi_file','id_cuti_ajukan','path','nama_file','jenis_file'];

    protected static function newFactory(): DokumenOutputFactory
    {
        //return DokumenOutputFactory::new();
    }
}
