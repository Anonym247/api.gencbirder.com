<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'id', 'menu_id', 'created_at', 'updated_at', 'deleted_at', 'pivot'
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($query) {
            if ($query->menu) {
                $menu = Menu::query()->find($query->menu)->first();

                if ($query->is_for_menu) {
                    $query->slug = $menu->url;
                } else {
                    $query->slug = $menu->url . '/' . Str::slug($query->title);
                }
            }
        });
    }

    public function relatedPages(): BelongsToMany
    {
        return $this->belongsToMany(
            Page::class,
            'page_pivot',
            'page_id',
            'related_page_id',
            'id'
        );
    }
}
