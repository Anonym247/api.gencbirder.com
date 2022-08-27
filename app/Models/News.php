<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class News extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'is_active', 'cover', 'updated_at', 'deleted_at'];

    protected $appends = [
        'media'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($query) {
            $query->slug = Str::slug($query->title);
        });
    }

    public function getMediaAttribute(): ?string
    {
        return photoToMedia($this->getAttribute('cover'));
    }
}
