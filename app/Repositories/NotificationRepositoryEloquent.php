<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\NotificationRepository;
use App\Entities\Notification;
use App\Presenters\NotificationPresenter;

/**
 * Class NotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    /**
     * @return string
     */
    public function presenter(): string
    {
        return NotificationPresenter::class;
    }
    
}
