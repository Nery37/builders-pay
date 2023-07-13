<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\ChargeRepository;
use App\Entities\Charge;
use App\Presenters\ChargePresenter;

/**
 * Class ChargeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChargeRepositoryEloquent extends BaseRepository implements ChargeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Charge::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return ChargePresenter::class;
    }
    
}
