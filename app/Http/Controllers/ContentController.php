<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $slider = Slider::with([
            'images' => function ($query) {
                $query->where('is_active', 1);
            }
        ])->first();

        return $this->data(__('messages.slider'), $slider);
    }
}
