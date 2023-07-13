<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Enums\TokenAbilityEnum;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\RepositoryInterface;

class AuthService extends AppService
{
    protected RepositoryInterface $repository;
    protected PasswordResetRepository $passwordResetRepository;

    /**
     * @param UserRepository          $repository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(
        UserRepository $repository,
        PasswordResetRepository $passwordResetRepository
    ) {
        $this->repository = $repository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function login(array $data): array
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!Auth::attempt($credentials)) {
            throw new \Exception('Unauthorized', 401);
        }

        $user = Auth::user();

        if (!empty($data['fcm_id'])) {
            $this->setDevice($data, $user);
        }

        return ['data' => $this->generateAccessToken($user)];
    }

    /**
     * @param User $user
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function refreshToken(User $user): array
    {
        $this->logout($user);
        return ['data' => $this->generateAccessToken($user)];
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public function forgot(array $data): void
    {
        try {
            DB::beginTransaction();
            $passwordReset = $this->passwordResetRepository
                ->skipPresenter()
                ->findWhere(['email' => $data['email']])
                ->first();

            if (empty($passwordReset) || $passwordReset->created_at->addMinutes(2) <= Carbon::now()) {
                if (!empty($reset)) {
                    $this->passwordResetRepository->delete($passwordReset->id);
                }

                $newPasswordReset = [
                    'email' => $data['email'],
                    'token' => str_replace('/', '', bcrypt($data['email']))
                ];

                $this->passwordResetRepository->skipPresenter()->create($newPasswordReset);

                DB::commit();
                return;
            }
            DB::rollBack();
            throw new \Exception('Recuperação de senha já foi solicitado com esse endereço de email!', 422);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            if (422 == !$exception->getCode()) {
                DB::rollBack();
                throw new \Exception('Falha ao solicitar reset de senha!', 500);
            }

            throw $exception;
        }
    }

    /**
     * @param array $data
     */
    public function resetPassword(array $data): void
    {
        $passwordReset = $this->passwordResetRepository
            ->skipPresenter()
            ->findWhere(['token' => $data['token']])
            ->first();

        $user = $this->repository->skipPresenter()->findWhere(['email' => $passwordReset->email])->first();

        $this->repository->update(['password' => bcrypt($data['password'])], $user->id);

        $this->passwordResetRepository->delete($passwordReset->id);

        $this->logout($user);
    }

    /**
     * @param Authenticatable $user
     *
     * @return array
     */
    public function generateAccessToken(Authenticatable $user): array
    {
        $accessToken = $user->createToken(
            'access_token',
            [TokenAbilityEnum::ACCESS_API->value],
            Carbon::now()->addMinutes(config('sanctum.expiration'))
        );

        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbilityEnum::ISSUE_ACCESS_TOKEN->value],
            Carbon::now()->addMinutes(config('sanctum.rt_expiration'))
        );

        return [
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * @param array           $data
     * @param Authenticatable $user
     *
     * @throws \Exception
     */
    private function setDevice(array $data, Authenticatable $user): void
    {
        try {
            $this->repository
                ->where(
                    [
                        'fcm_id' => $data['fcm_id']
                    ]
                )->update([
                    'fcm_id' => null,
                ]);

            $this->repository->update([
                'fcm_id' => $data['fcm_id']
            ], $user->id);

            return;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), 500);
        }
    }
}
