<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Services\PageService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    use ApiResponder;

    /**
     * @throws ValidationException
     */
    public function index(Request $request, PageService $pageService)
    {
        $this->validate($request, [
            'slug' => 'required|string'
        ]);

        $slug = trim($request->get('slug'), '/\\&?');

        $page = Page::query()
            ->where('slug', $slug)
            ->with('relatedPages:slug,title')
            ->first();

        if (!$page) {
            if ($slug = $this->slugOfNews($slug)) {
                $news = News::query()
                    ->where('is_active', true)
                    ->where('slug', $slug)
                    ->firstOrFail(['title', 'content', 'cover', 'created_at']);

                return $this->data(__('messages.show'), [
                    'type' => "news",
                    'news' => $news,
                ]);
            }

            return $this->error(__('messages.page_not_found'), 404);
        }

        if ($page->type !== "reports") {
            $page->load([
                'documents' => function ($query) {
                    $query->where('report_groups.is_active', 1);
                    $query->where('reports.is_active', 1);
                    $query->select(['reports.title', 'reports.file']);
                }
            ]);
        }

        $defaultData = [
            'type' => $page->type,
            'title' => $page->title,
            'photo' => photoToMedia($page->photo),
            'related' => $page->relatedPages,
            'documents' => $page->relationLoaded('documents') ? $page->documents : [],
        ];

        if ($page->type === 'team') {
            $members = $pageService->getMembersTree($page->getKey());

            return $this->data(__('messages.list'), array_merge($defaultData, [
                'items' => $members
            ]));
        }

        if ($page->type === 'banner') {
            return $this->data(__('messages.show'), array_merge($defaultData, [
                'banner' => photoToMedia($page->banner_photo),
                'attachment_photo' => photoToMedia($page->attachment_photo),
                'attachment_url' => $page->attachment_url,
            ]));
        }

        if ($page->type === 'reports') {
            $reportGroups = $pageService->getReportGroups($page->getKey());

            return $this->data(__('messages.list'), array_merge($defaultData, [
                'items' => $reportGroups,
            ]));
        }

        return $this->data(__('messages.list'), array_merge($defaultData, [
            'content' => $page->content,
            'video' => $page->video,
        ]));
    }

    private function slugOfNews($slug): ?string
    {
        $parts = explode('/', $slug);

        if ($parts[0] === config('defaults.news_prefix')) {
            return $parts[1];
        }

        return null;
    }
}
