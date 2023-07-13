<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\PasswordReset;
use App\Presenters\PasswordResetPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PasswordResetRepositoryEloquent.
 */
class PasswordResetRepositoryEloquent extends BaseRepository implements PasswordResetRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return PasswordReset::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return PasswordResetPresenter::class;
    }
}
