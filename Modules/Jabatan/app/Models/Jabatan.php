<?php

namespace Modules\Jabatan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Jabatan\Database\Factories\JatabanFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Jabatan extends Model
{
    use HasFactory;
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "tb_jabatan";
    protected $fillable = ["nama_jabatan"];
    protected $dates = ['deleted_at'];
    protected static function newFactory(): JatabanFactory
    {
        //return JatabanFactory::new();
    }
}
