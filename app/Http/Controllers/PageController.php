<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $slug = $request->get('slug');

        $page = Page::query()->where('slug', $slug)->first();

        if (!$page) {
            return $this->error(__('messages.page_not_found'), 404);
        }

        return $this->data(__('messages.success'), $page);
    }
}
