<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['report_group_id', 'file', 'laravel_through_key'];

    protected $appends = [
        'url'
    ];

    public function group()
    {
        return $this->belongsTo(ReportGroup::class, 'report_group_id', 'id');
    }

    public function getUrlAttribute(): ?string
    {
        return photoToMedia($this->getAttribute('file'));
    }
}
