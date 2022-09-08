<?php

namespace App\Services;

use App\Http\Resources\MembersResource;
use App\Models\Form;
use App\Models\MemberGroup;
use App\Models\ReportGroup;
use Illuminate\Database\Eloquent\Collection;

class PageService
{
    public function getReportGroups(int $pageId): Collection|array
    {
        return ReportGroup::query()->where('is_active', 1)
            ->where('page_id', $pageId)
            ->with([
                'reports' => function ($query) {
                    $query->where('is_active', 1);
                    $query->select(['report_group_id', 'title', 'file']);
                }
            ])
            ->get(['id', 'title']);
    }

    public function getMembersTree(int $pageId)
    {
        $items = MemberGroup::query()->where('is_active', 1)
            ->where('page_id', $pageId)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $resource = MembersResource::collection($items)->response()->getData(true);

        return $resource['data'] ?? [];
    }

    public function getForm(int $pageId)
    {
        $form = Form::with('sections.attributes')->where('page_id', $pageId)->firstOrFail();

        return $form;
    }
}
