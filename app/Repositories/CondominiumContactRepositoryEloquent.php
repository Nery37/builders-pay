<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\CondominiumContactRepository;
use App\Entities\CondominiumContact;
use App\Presenters\CondominiumContactPresenter;

/**
 * Class CondominiumContactRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CondominiumContactRepositoryEloquent extends BaseRepository implements CondominiumContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CondominiumContact::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return CondominiumContactPresenter::class;
    }
}
