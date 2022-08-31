<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Services\MemberService;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    use ApiResponder;

    /**
     * @throws ValidationException
     */
    public function index(Request $request, MemberService $memberService)
    {
        $this->validate($request, [
            'slug' => 'required|string'
        ]);

        $slug = $request->get('slug');

        $page = Page::query()->where('slug', $slug)->first();

        if (!$page) {
            if ($slug = $this->slugOfNews($slug)) {
                $news = News::query()->where('is_active', true)->where('slug', $slug)->firstOrFail();

                return $this->data(__('messages.news'), $news);
            }

            return $this->error(__('messages.page_not_found'), 404);
        }

        if ($page->type === 'team') {
            $members = $memberService->getMembersTree();

            return $this->data(__('messages.members'), $members);
        }

        return $this->data(__('messages.success'), $page);
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
