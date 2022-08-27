<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'parent_id', 'is_active', 'created_at', 'updated_at', 'deleted_at', 'photo'
    ];

    protected $appends = [
        'media'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->with('children');
    }

    public function getMediaAttribute(): ?string
    {
        return photoToMedia($this->getAttribute('photo'));
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($query) {
            if ($query->parent) {
                $parent = Menu::query()->find($query->parent)->first();
                $query->url = $parent->url . '/' . Str::slug($query->name);
            } else if (empty($query->url)) {
                $query->url = Str::slug($query->name);
            }
        });
    }
}
