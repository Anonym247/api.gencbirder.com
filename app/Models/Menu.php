<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'parent_id', 'is_active', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->with('children');
    }
}
