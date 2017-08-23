<?php

namespace Tests\TestCases;

use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mockery\MockInterface;

class QueryComposerTestCase extends UnitTestCase
{
    /** @var array */
    protected $repositories = [];

    /** @var array|Collection */
    protected $queryResult = [];

    /**
     * @param string $repositoryName
     * @param string[] $methods
     * @return AbstractRepository|MockInterface
     */
    protected function mockRepository($repositoryName, array $methods)
    {
        /** @var AbstractRepository|MockInterface $repository */
        $repository = \Mockery::mock($repositoryName);
        $this->repositories[$repositoryName] = [];
        foreach ($methods as $method) {
            $repository->shouldReceive($method)->andReturnUsing(function () use ($repositoryName, $method) {
                $args = func_get_args();
                if ($args[0] instanceof Builder) {
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
        $eloquentBuilder->shouldReceive('get')->andReturnUsing([$this, 'getQueryResultCallback']);
        return $eloquentBuilder;
    }

    public function getQueryResultCallback()
    {
        return $this->queryResult;
    }
}
