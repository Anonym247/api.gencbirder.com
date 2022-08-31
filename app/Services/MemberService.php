<?php

namespace App\Services;


use App\Http\Resources\MembersResource;
use App\Models\MemberGroup;

class MemberService
{
    public function getMembersTree()
    {
        $items = MemberGroup::query()->where('is_active', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $resource = MembersResource::collection($items)->response()->getData(true);

        return $resource['data'] ?? [];
    }
}
