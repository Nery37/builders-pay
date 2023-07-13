<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Presenters\Trait\PresentTrait;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 */
class UserPresenter extends FractalPresenter
{
    use PresentTrait;
}
