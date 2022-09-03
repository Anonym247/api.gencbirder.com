<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Models\UserAddressType;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserAddressController extends Controller
{
    use ApiResponder;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserAddressTypes(Request $request): JsonResponse
    {
        $types = UserAddressType::query()
            ->where('is_active', 1)
            ->get();

        return $this->data(__('messages.list'), $types);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = getAuthUser();

        $addresses = UserAddress::query()
            ->with([
                'province', 'district', 'quarter', 'userAddressType'
            ])
            ->where('user_id', $user->getAuthIdentifier())
            ->get();

        return $this->data(__('messages.list'), $addresses);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, $this->getValidationRules());

        UserAddress::query()->create([
            'user_id' => getAuthUser()->getAuthIdentifier(),
            'user_address_type_id' => $request->get('user_address_type_id'),
            'province_id' => $request->get('province_id'),
            'district_id' => $request->get('district_id'),
            'quarter_id' => $request->get('quarter_id'),
            'title' => $request->get('title'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'full_address' => $request->get('full_address'),
        ]);

        return $this->success(__('messages.saved'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, $this->getValidationRules());

        $userAddress = UserAddress::query()->where('user_id', getAuthUser()->getAuthIdentifier())->findOrFail($id);

        $userAddress->update([
            'user_address_type_id' => $request->get('user_address_type_id'),
            'province_id' => $request->get('province_id'),
            'district_id' => $request->get('district_id'),
            'quarter_id' => $request->get('quarter_id'),
            'title' => $request->get('title'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'full_address' => $request->get('full_address'),
        ]);

        return $this->success(__('messages.updated'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $address = UserAddress::query()->where('user_id', getAuthUser()->getAuthIdentifier())->findOrFail($id);

        $address->delete();

        return $this->success(__('messages.deleted'));
    }

    /**
     * @return \string[][]
     */
    private function getValidationRules(): array
    {
        return [
            'user_address_type_id' => ['required', 'exists:user_address_types,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'quarter_id' => ['required', 'exists:quarters,id'],
            'title' => ['required', 'string', 'min:3'],
            'name' => ['required', 'string', 'min:3'],
            'phone' => ['required', 'string', 'min:5'],
            'full_address' => ['required', 'string', 'min:5'],
        ];
    }
}
