<?php

namespace Tests\Unit\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\FractalDataRetriever;
use DentalSleepSolutions\Http\Requests\ContactType;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\Manager;
use League\Fractal\Scope;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class FractalDataRetrieverTest extends UnitTestCase
{
    /** @var array */
    private $result = [];

    /** @var FractalDataRetriever */
    private $fractalDataRetriever;

    public function setUp()
    {
        $this->result['data'] = 'foo';

        $fractalManager = $this->mockFractalManager();
        $this->fractalDataRetriever = new FractalDataRetriever($fractalManager);
    }

    public function testWithScalarArgument()
    {
        $data = 'foo';
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertNull($fractalData);
    }

    public function testWithResource()
    {
        $data = new Patient();
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertEquals('foo', $fractalData);
    }

    public function testWithArray()
    {
        $data = [new Patient(), new Patient()];
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertEquals('foo', $fractalData);
    }

    public function testWithEmptyArray()
    {
        $data = [];
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertNull($fractalData);
    }

    public function testWithArrayOfScalars()
    {
        $data = ['foo', 'bar', 'baz'];
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertNull($fractalData);
    }

    public function testWithTraversable()
    {
        $data = new Collection();
        $data->add(new Patient());
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertEquals('foo', $fractalData);
    }

    public function testWithMalformedData()
    {
        $this->result = [];
        $data = new Patient();
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage('Fractal result must have \'data\' property');
        $this->fractalDataRetriever->getFractalData($data);
    }

    public function testWithNonexistentTransformer()
    {
        $data = new ContactType();
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        $this->assertNull($fractalData);
    }

    private function mockFractalManager()
    {
        /** @var Manager|MockInterface $fractalManager */
        $fractalManager = \Mockery::mock(Manager::class);
        $fractalManager->shouldReceive('createData')->andReturn($this->mockScope());
        return $fractalManager;
    }

    private function mockScope()
    {
        /** @var Scope|MockInterface $scope */
        $scope = \Mockery::mock(Scope::class);
        $scope->shouldReceive('toArray')
            ->andReturnUsing(function () {
                return $this->result;
            });
        return $scope;
    }
}
