<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Contracts\SingularAndPluralInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model implements SingularAndPluralInterface
{
    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getSingular()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getPlural()
    {
        $reflection = new \ReflectionClass($this);
        return str_plural($reflection->getShortName());
    }
}
