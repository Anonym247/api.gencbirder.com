<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['id', 'name', 'created_at', 'updated_at', 'attachment_photo'];

    protected $appends = [
        'attachment_media'
    ];

    public function images()
    {
        return $this->hasMany(SliderImage::class);
    }

    public function getAttachmentMediaAttribute(): string
    {
        return env('APP_URL') . '/storage/' . $this->attachment_photo;
    }
}
