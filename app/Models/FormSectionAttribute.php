<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSectionAttribute extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'form_section_id'];

    public function formSection()
    {
        return $this->belongsTo(FormSection::class, 'form_section_id', 'id');
    }

    public function referenceAttribute()
    {
        return $this->belongsTo(FormSectionAttribute::class, 'reference_attribute_id', 'id');
    }
}
