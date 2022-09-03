<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponder;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProfile(Request $request): JsonResponse
    {
        $user = User::with([
            'province',
            'district',
        ])->get(['firstname', 'lastname', 'phone', 'email', 'birthday', 'sex', 'province_id', 'district_id']);

        return $this->data(__('messages.profile'), $user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(auth()->id())],
            'phone' => ['nullable', 'string', 'min:5'],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
            'sex' => ['nullable', 'string', 'in:male,female'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
        ]);

        $parts = explode(' ', $request->get('name'));

        $user = Auth::guard('api')->user();

        $user->update([
            'firstname' => $parts[0],
            'lastname' => $parts[1] ?? '',
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'birthday' => $request->get('birthday'),
            'sex' => $request->get('sex'),
            'province_id' => $request->get('province_id'),
            'district_id' => $request->get('district_id'),
        ]);

        return $this->success(__('messages.saved'));
    }
}
