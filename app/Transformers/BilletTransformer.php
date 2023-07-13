<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Billet;

/**
 * Class BilletTransformer.
 *
 * @package namespace App\Transformers;
 */
class BilletTransformer extends TransformerAbstract
{
    /**
     * Transform the Billet entity.
     *
     * @param \App\Entities\Billet $model
     *
     * @return array
     */
    public function transform(Billet $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
