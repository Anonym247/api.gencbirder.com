<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderImage extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'slider_id', 'created_at', 'deleted_at', 'updated_at', 'is_active', 'photo'];

    protected $appends = [
        'media'
    ];

    public function getMediaAttribute(): string
    {
        return env('APP_URL') . '/storage/' . $this->photo;
    }
}
