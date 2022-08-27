<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'is_active', 'icon', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = [
        'media'
    ];

    public function getMediaAttribute(): ?string
    {
        return photoToMedia($this->getAttribute('icon'));
    }
}
