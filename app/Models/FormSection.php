<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSection extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'donation_price_checking_attributes' => 'array',
    ];

    protected $hidden = ['form_id', 'page_id', 'created_at', 'updated_at', 'deleted_at'];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(FormSectionAttribute::class, 'form_section_id', 'id');
    }
}
