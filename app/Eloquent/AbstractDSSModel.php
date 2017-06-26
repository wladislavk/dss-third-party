<?php

namespace DentalSleepSolutions\Eloquent;

abstract class AbstractDSSModel extends AbstractModel
{
    public function updateStatic(AbstractDSSModel $model, array $data)
    {
        $model->update($data);
    }
}
