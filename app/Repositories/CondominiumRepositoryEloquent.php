<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Condominium;
use App\Presenters\CondominiumPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CondominiumsRepositoryEloquent.
 */
class CondominiumRepositoryEloquent extends BaseRepository implements CondominiumRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Condominium::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return CondominiumPresenter::class;
    }
}
