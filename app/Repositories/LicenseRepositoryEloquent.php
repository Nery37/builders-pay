<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\LicenseRepository;
use App\Entities\License;
use App\Presenters\LicensePresenter;

/**
 * Class LicenseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LicenseRepositoryEloquent extends BaseRepository implements LicenseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return License::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return LicensePresenter::class;
    }
    
}
