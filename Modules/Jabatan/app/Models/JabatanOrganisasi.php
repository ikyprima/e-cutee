<?php

namespace Modules\Jabatan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Jabatan\Database\Factories\JabatanOrganisasiFactory;

class jabatanOrganisasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
     protected $table = 'tb_jabatan_organisasi';
     protected $fillable = ['nama_jabatan'];

    protected static function newFactory(): JabatanOrganisasiFactory
    {
        //return JabatanOrganisasiFactory::new();
    }
}
