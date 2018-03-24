<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Support\Facades\App;

class RepositoryFactory
{
    /**
     * @param string $className
     * @return AbstractRepository
     * @throws GeneralException
     */
    public function getRepository(string $className): AbstractRepository
    {
        if (!class_exists($className) || !is_subclass_of($className, AbstractRepository::class)) {
            throw new GeneralException("Class $className must exist and extend " . AbstractRepository::class);
        }
        return App::make($className);
    }
}
