<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Person;
use App\Presenters\PersonPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PeopleRepositoryEloquent.
 */
class PersonRepositoryEloquent extends BaseRepository implements PersonRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return Person::class;
    }

    public function presenter(): string
    {
        return PersonPresenter::class;
    }
}
