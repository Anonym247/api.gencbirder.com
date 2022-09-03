<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Quarter;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    use ApiResponder;

    public function provinces(Request $request): JsonResponse
    {
        $provinces = Province::query()->where('is_active', 1)->get(['id', 'name']);

        return $this->data(__('messages.list'), $provinces);
    }

    public function districts(Request $request, $id): JsonResponse
    {
        $districts = District::query()
            ->whereHas('province', function ($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_active', 1);
            })
            ->where('is_active', 1)
            ->get(['id', 'province_id', 'name']);

        return $this->data(__('messages.list'), $districts);
    }

    public function quarters(Request $request, $id): JsonResponse
    {
        $quarters = Quarter::query()
            ->whereHas('district', function ($query) use ($id) {
                $query->where('id', $id);
                $query->where('is_active', 1);
            })
            ->where('is_active', 1)
            ->get(['id', 'district_id', 'name']);

        return $this->data(__('messages.list'), $quarters);
    }
}
