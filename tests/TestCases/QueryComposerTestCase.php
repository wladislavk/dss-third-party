<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Console\Commands\Api\Model;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Structs\QueryCollections\AbstractQueryCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;

class QueryComposerTestCase extends UnitTestCase
{
    /** @var array */
    protected $repositories = [];

    /** @var array|Collection */
    protected $queryResult = [];

    /** @var Model */
    protected $firstResult;

    protected function mockRepository($repositoryName, array $methods)
    {
        /** @var AbstractRepository|MockInterface $repository */
        $repository = \Mockery::mock($repositoryName);
        $this->repositories[$repositoryName] = [];
        foreach ($methods as $method) {
            $repository->shouldReceive($method)->andReturnUsing(function () use ($repositoryName, $method) {
                $args = func_get_args();

                if (isset($args[0]) && ($args[0] instanceof Builder || $args[0] instanceof AbstractQueryCollection)) {
                    array_shift($args);
                }

                $this->repositories[$repositoryName][$method][] = $args;
                return $this->mockEloquentBuilder();
            });
        }

        return $repository;
    }

    protected function mockEloquentBuilder()
    {
        /** @var Builder|MockInterface $eloquentBuilder */
        $eloquentBuilder = \Mockery::mock(Builder::class);
        $eloquentBuilder->shouldReceive('get')->andReturnUsing(function () {
            return $this->queryResult;
        });
        $eloquentBuilder->shouldReceive('first')->andReturnUsing(function () {
            return $this->firstResult;
        });
        return $eloquentBuilder;
    }
}
