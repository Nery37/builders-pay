<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AppService;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController.
 */
class AuthController extends Controller
{
    protected AppService $service;

    /**
     * @param AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);

            return $this->successResponse($this->service->login($request->all()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->service->logout($request->user());

            return $this->successResponse([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        try {
            return $this->successResponse($this->service->refreshToken($request->user()));
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param ForgotPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->forgot($request->all());
            return $this->successResponse(['data' => ['message' => 'Reset de senha enviado!']]);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->service->resetPassword($request->all());
            return $this->successResponse(['data' => ['message' => 'Senha atualizada com sucesso!']]);
        } catch (\Exception $exception) {
            dd($exception);
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
