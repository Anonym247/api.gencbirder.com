<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const SUPERADMIN = 1;
    public const VOLUNTEER = 2;

    protected $guarded = ['id'];

    public $timestamps = false;
}
