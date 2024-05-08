<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Role\Database\Factories\RoleFactory;
use Spatie\Permission\Models\Role as SpatieRole;
class role extends SpatieRole
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): RoleFactory
    {
        //return RoleFactory::new();
    }
}
