<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    private $userRepository;

    /**
     * Create a new AuthController instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $validator = $this->validateUserRequest($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $userData = [
                'email' => $request->input('email'),
                'roles' => $request->input('roles'),
                'nisn' => $request->input('nisn'),
                'password' => $request->input('password'),
            ];

            $user = $this->userRepository->create($userData);

            return response()->json(['data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create User. ' . $e->getMessage()], 422);
        }
    }

    protected function validateUserRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'roles' => 'required|string',
            'nisn' => 'nullable|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => ['required', 'string', 'min:2', Password::defaults()],
        ], [
            'nisn.unique' => 'Nisn is already taken.',
            'email.unique' => 'Email is already taken.',
        ]);
    }



    protected function validateCompanyRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'founder_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => ['required', 'numeric', 'unique:companies,phone_number'],
            'email' => 'email|unique:companies',
            'password' => ['required', 'string', 'min:2', Password::defaults()],
        ], [
            'email.unique' => 'Email is already taken.',
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'email', 'nisn', 'password');

        if (!$token = $this->userRepository->attemptLogin($credentials)) {
            return response()->json(['error' => 'incorrect input'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}