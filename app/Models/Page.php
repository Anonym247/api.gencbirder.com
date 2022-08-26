<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'menu_id', 'created_at, updated_at', 'deleted_at',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($query) {
            $menu = Menu::query()->find($query->menu)->first();

            $query->slug = $menu->url . '/' . Str::slug($query->title);
        });
    }
}
