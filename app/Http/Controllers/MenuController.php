<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $menus = Menu::with('children')->where('is_active', 1)->get();

        return $this->data(__('messages.list'), $menus);
    }
}
