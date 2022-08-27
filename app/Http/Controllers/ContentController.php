<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\News;
use App\Models\Slider;
use App\Models\Stat;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    use ApiResponder;

    public function slider(Request $request)
    {
        $slider = Slider::with([
            'images' => function ($query) {
                $query->where('is_active', 1);
            }
        ])->first();

        return $this->data(__('messages.slider'), $slider);
    }

    public function stats(Request $request)
    {
        $stats = Stat::query()->where('is_active', 1)->get();

        return $this->data(__('messages.stats'), $stats);
    }

    public function activities(Request $request)
    {
        $activities = Activity::query()->where('is_active', 1)->get();

        return $this->data(__('messages.activities'), $activities);
    }

    public function news(Request $request)
    {
        $news = News::query()->where('is_active', 1)->get();

        return $this->data(__('messages.news'), $news);

    }
}
