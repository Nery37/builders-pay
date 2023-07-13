<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * UserService.
 */
class UserService extends AppService
{
    protected RepositoryInterface $repository;

    private AuthService $authService;

    /**
     * @param UserRepository $repository
     * @param AuthService    $authService
     */
    public function __construct(
        UserRepository $repository,
        AuthService $authService,
    ) {
        $this->repository = $repository;
        $this->authService = $authService;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function signup(array $data): array
    {
        try {
            DB::beginTransaction();
            $user = $this->create($data, true);
            $data['user_id'] = $user->id;
            $accessToken = $this->authService->generateAccessToken($user);

            DB::commit();
            return ['data' => $accessToken];
        } catch (\Exception) {
            DB::rollBack();
            throw new \Exception('Falha ao criar usuário', 500);
        }
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function userInfo(User $user): array
    {
        return $this->repository->find($user->id);
    }
}
