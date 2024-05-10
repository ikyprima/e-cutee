<?php

namespace Modules\Pegawai\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Pegawai\Database\Factories\PegawaiFactory;

class pegawai extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): PegawaiFactory
    {
        //return PegawaiFactory::new();
    }
}
