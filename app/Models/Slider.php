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

    public function getAttachmentMediaAttribute(): ?string
    {
        return photoToMedia($this->getAttribute('attachment_photo'));
    }
}
