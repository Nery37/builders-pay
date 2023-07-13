<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\CommonAreaRepository;
use App\Entities\CommonArea;
use App\Presenters\CommonAreaPresenter;

/**
 * Class CommonAreaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CommonAreaRepositoryEloquent extends BaseRepository implements CommonAreaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CommonArea::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return CommonAreaPresenter::class;
    }
    
}
