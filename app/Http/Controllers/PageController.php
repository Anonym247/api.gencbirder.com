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

        $page = Page::query()->where('slug', $slug)->with('relatedPages:slug,title')->first();

        if (!$page) {
            if ($slug = $this->slugOfNews($slug)) {
                $news = News::query()->where('is_active', true)->where('slug', $slug)->firstOrFail();

                return $this->data(__('messages.news'), [
                    'type' => "news",
                    'values' => $news,
                ]);
            }

            return $this->error(__('messages.page_not_found'), 404);
        }

        if ($page->type === 'team') {
            $members = $pageService->getMembersTree($page->getKey());

            return $this->data(__('messages.members'), [
                'type' => $page->type,
                'photo' => photoToMedia($page->photo),
                'items' => $members,
                'related' => $page->relatedPages,
            ]);
        }

        if ($page->type === 'banner') {
            return $this->data(__('messages.banner'), [
                'type' => 'banner',
                'title' => $page->title,
                'banner' => photoToMedia($page->banner_photo),
                'attachment_photo' => photoToMedia($page->attachment_photo),
                'attachment_url' => $page->attachment_url,
                'related' => $page->relatedPages,
            ]);
        }

        if ($page->type === 'reports') {
            $reportGroups = $pageService->getReportGroups($page->getKey());

            return $this->data(__('messages.list'), [
                'type' => $page->type,
                'photo' => photoToMedia($page->photo),
                'items' => $reportGroups,
                'related' => $page->relatedPages,
            ]);
        }

        return $this->data(__('messages.success'), [
            'type' => $page->type,
            'values' => [
                'slug' => $page->slug,
                'title' => $page->title,
                'photo' => photoToMedia($page->photo),
                'content' => $page->content,
                'video' => $page->video,
            ],
            'related' => $page->relatedPages,
        ]);
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
