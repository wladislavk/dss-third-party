<?php

namespace DentalSleepSolutions\Structs\QueryCollections;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\ObjectTypeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

abstract class AbstractQueryCollection extends Collection
{
    /**
     * @return Builder[]|QueryBuilder[]
     */
    public function all()
    {
        return parent::all();
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return Builder|QueryBuilder
     * @throws ObjectTypeException
     */
    public function get($key, $default = null)
    {
        $element = parent::get($key, $default);
        if (!$element instanceof Builder) {
            throw new ObjectTypeException($element, Builder::class);
        }
        return $element;
    }
}
