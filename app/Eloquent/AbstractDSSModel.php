<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDSSModel extends Model
{
    public function updateStatic(AbstractDSSModel $model, array $data)
    {
        $model->update($data);
    }
}
