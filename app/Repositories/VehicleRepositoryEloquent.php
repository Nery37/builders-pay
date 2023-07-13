<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Entities\Vehicle;
use App\Presenters\VehiclePresenter;

/**
 * Class VehiclesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VehicleRepositoryEloquent extends BaseRepository implements VehicleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vehicle::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return VehiclePresenter::class;
    }
}
