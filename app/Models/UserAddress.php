<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [
        'user_id', 'user_address_type_id', 'created_at', 'updated_at', 'deleted_at', 'province_id', 'quarter_id',
        'district_id',
    ];

    public function userAddressType(): BelongsTo
    {
        return $this->belongsTo(UserAddressType::class, 'user_address_type_id', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function quarter(): BelongsTo
    {
        return $this->belongsTo(Quarter::class, 'quarter_id', 'id');
    }
}
