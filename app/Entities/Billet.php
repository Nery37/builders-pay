<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Billet.
 */
class Billet extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'billets';

    protected $fillable = [
        'code',
        'original_amount',
        'due_date',
        'payment_date',
        'interest_amount_calculated',
        'fine_amount_calculated',
        'amount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
