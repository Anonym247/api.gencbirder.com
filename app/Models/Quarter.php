<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quarter extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = ['is_active', 'created_at', 'deleted_at', 'updated_at'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
