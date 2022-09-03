<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function sections()
    {
        return $this->hasMany(FormSection::class, 'form_id', 'id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
