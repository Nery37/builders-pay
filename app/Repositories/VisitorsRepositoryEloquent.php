<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VisitorsRepository;
use App\Entities\Visitors;
use App\Presenters\VisitorsPresenter;
use App\Validators\VisitorsValidator;

/**
 * Class VisitorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VisitorsRepositoryEloquent extends BaseRepository implements VisitorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Visitors::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return VisitorsPresenter::class;
    }
}
