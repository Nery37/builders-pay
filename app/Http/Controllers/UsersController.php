<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AppService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController.
 */
class UsersController extends Controller
{
    protected AppService $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signup(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users',
                'cpf' => 'required|string|unique:users',
                'password' => 'required|string',
            ]);

            return $this->successCreatedResponse($this->service->signup($request->all()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userInfo(Request $request): JsonResponse
    {
        try {
            return response()->json($this->service->userInfo($request->user()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
