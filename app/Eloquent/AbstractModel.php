<?php

namespace DentalSleepSolutions\Eloquent;

use DentalSleepSolutions\Contracts\SingularAndPluralInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model implements SingularAndPluralInterface
{
    /**
     * @return string
     */
    public function getSingular()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    /**
     * @return string
     */
    public function getPlural()
    {
        $reflection = new \ReflectionClass($this);
        return str_plural($reflection->getShortName());
    }
}
