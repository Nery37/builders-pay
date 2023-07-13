<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\BilletRepository;
use App\Entities\Billet;
use App\Presenters\BilletPresenter;

/**
 * Class BilletRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BilletRepositoryEloquent extends BaseRepository implements BilletRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Billet::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return BilletPresenter::class;
    }
    
}
