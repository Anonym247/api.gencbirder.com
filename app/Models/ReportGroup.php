<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportGroup extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    public function reports()
    {
        return $this->hasMany(Report::class, 'report_group_id', 'id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
