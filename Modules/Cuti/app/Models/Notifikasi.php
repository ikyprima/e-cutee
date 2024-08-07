<?php

namespace Modules\Cuti\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cuti\Database\Factories\NotifikasiFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table="tb_notifikasi";
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id_pegawai','id_ajukan_cuti','judul','deskripsi','status'];

    protected static function newFactory(): NotifikasiFactory
    {
        //return NotifikasiFactory::new();
    }
}
