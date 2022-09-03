<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponder;

    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['login', 'register']);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        [$firstname, $lastname] = explode(' ', $request->get('name'));

        User::create([
            'role_id' => Role::VOLUNTEER,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $this->success(__('messages.success'), 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password'),];

        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        throw new AuthenticationException(__('auth.invalid_credentials'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function refresh(Request $request): JsonResponse
    {
        if ($token = Auth::guard('api')->refresh()) {
            return $this->respondWithToken($token);
        }

        throw new AuthenticationException();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('api')->logout();

        return $this->success(__('auth.logged_out'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function changePassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:8'
        ]);

        $user = getAuthUser();

        if (!Hash::check($request->get('current_password'), $user->getAuthPassword())) {
            return $this->error(__('auth.password_incorrect'), 422);
        }

        $user->update([
            'password' => bcrypt($request->get('password'))
        ]);

        return $this->success(__('messages.saved'));
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    private function respondWithToken($token): JsonResponse
    {
        return $this->data(__('messages.success'), [
            'access_token' => $token,
            'refresh_token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }
}
