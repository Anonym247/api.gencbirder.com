<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(MemberGroup::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(MemberGroup::class, 'parent_id', 'id');
    }
}
