<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddressType extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['is_active', 'created_at', 'updated_at', 'deleted_at'];
}
