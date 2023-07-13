<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CommonAreaReservationRepository;
use App\Entities\CommonAreaReservation;
use App\Presenters\CommonAreaReservationPresenter;
use App\Validators\CommonAreaReservationValidator;

/**
 * Class CommonAreaReservationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CommonAreaReservationRepositoryEloquent extends BaseRepository implements CommonAreaReservationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CommonAreaReservation::class;
    }
    
    /**
     * @return string
     */
    public function presenter(): string
    {
        return CommonAreaReservationPresenter::class;
    }
}
