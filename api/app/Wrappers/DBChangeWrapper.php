<?php

namespace DentalSleepSolutions\Wrappers;

use Illuminate\Database\Eloquent\Model;

class DBChangeWrapper
{
    /**
     * @param Model $model
     */
    public function save(Model $model): void
    {
        $model->save();
    }

    /**
     * @param Model $model
     * @throws \Exception
     */
    public function delete(Model $model): void
    {
        $model->delete();
    }
}
