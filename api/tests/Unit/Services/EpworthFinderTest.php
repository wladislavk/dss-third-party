<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Repositories\Dental\EpworthSleepinessScaleRepository;
use DentalSleepSolutions\Services\EpworthFinder;
use DentalSleepSolutions\Eloquent\Models\Dental\EpworthSleepinessScale;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class EpworthFinderTest extends UnitTestCase
{
    /** @var string */
    private $order = '';

    /** @var EpworthSleepinessScale[] */
    private $dbData = [];

    /** @var EpworthFinder */
    private $epworthFinder;

    public function setUp()
    {
        $firstRecord = new EpworthSleepinessScale();
        $firstRecord->epworthid = 1;
        $firstRecord->status = '1';
        $secondRecord = new EpworthSleepinessScale();
        $secondRecord->epworthid = 2;
        $secondRecord->status = '1';
        $thirdRecord = new EpworthSleepinessScale();
        $thirdRecord->epworthid = 3;
        $thirdRecord->status = '2';
        $this->dbData = [$firstRecord, $secondRecord, $thirdRecord];

        $repo = $this->mockRepository();
        $this->epworthFinder = new EpworthFinder($repo);
    }

    public function testFindEpworth()
    {
        $status = '';
        $order = '';
        $result = $this->epworthFinder->findEpworth($status, $order);
        $this->assertEquals(3, sizeof($result));
    }

    public function testWithOrderAndStatus()
    {
        $status = '1';
        $order = 'foo';
        $result = $this->epworthFinder->findEpworth($status, $order);
        $this->assertEquals(2, sizeof($result));
        $this->assertEquals('foo', $this->order);
    }

    private function mockRepository()
    {
        /** @var MockInterface|EpworthSleepinessScaleRepository $repo */
        $repo = \Mockery::mock(EpworthSleepinessScaleRepository::class);
        $repo->shouldReceive('orderBy')->andReturnUsing(function ($order) {
            $this->order = $order;
        });
        $repo->shouldReceive('findWhere')->andReturnUsing(function (array $conditions) {
            $result = [];
            foreach ($this->dbData as $record) {
                if (!isset($conditions['status']) || $record->status == $conditions['status']) {
                    $result[] = $record;
                }
            }
            return $result;
        });
        return $repo;
    }
}
