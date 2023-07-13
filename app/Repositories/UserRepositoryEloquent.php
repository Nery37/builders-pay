<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Presenters\UserPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return UserPresenter::class;
    }
}
