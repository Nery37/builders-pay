<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\UserCondominiumRepository;
use App\Entities\UserCondominium;
use App\Presenters\UserCondominiumPresenter;

/**
 * Class UserCondominiumRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserCondominiumRepositoryEloquent extends BaseRepository implements UserCondominiumRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserCondominium::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return UserCondominiumPresenter::class;
    }
    
}
