<?php
namespace Tests\TestCases;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class ApiTestCase extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    const ROUTE_PREFIX = '/api/v1';

    protected $table;

    /** @var int */
    protected $userId = 100;

    /**
     * @return string
     */
    abstract protected function getModel();

    /**
     * @return string
     */
    abstract protected function getRoute();

    public function setUp()
    {
        parent::setUp();
        $modelClass = $this->getModel();
        /** @var Model $model */
        $model = new $modelClass();
        $this->table = $model->getTable();
    }

    public function testStore()
    {
        $data = factory($this->getModel())->make()->toArray();

        $data['userid'] = $this->userId;

        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $data);
        $this->assertResponseOk();
        $this->seeInDatabase($this->table, ['userid' => $this->userId]);
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->create();

        $data['adminid'] = $this->userId;

        $this->put(self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->id, $data);
        $this->assertResponseOk();
        $this->seeInDatabase($this->table, ['adminid' => $this->userId]);
    }

    public function testDestroy()
    {
        $testRecord = factory($this->getModel())->create();

        $this->delete(self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->id);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->table, ['id' => $testRecord->id]);
    }
}
