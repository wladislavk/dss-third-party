<?php
namespace Tests\TestCases;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class ApiTestCase extends BaseApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @var Model */
    protected $model;

    /**
     * @return string
     */
    abstract protected function getModel();

    /**
     * @return string
     */
    abstract protected function getRoute();

    /**
     * @return array
     */
    abstract protected function getStoreData();

    /**
     * @return array
     */
    abstract protected function getUpdateData();

    public function setUp()
    {
        parent::setUp();
        $modelClass = $this->getModel();
        $this->model = new $modelClass();
    }

    public function testIndex()
    {
        factory($this->getModel())->create();
        $this->get(self::ROUTE_PREFIX . $this->getRoute(), $this->getStoreData());
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($this->getResponseData()));
    }

    public function testShow()
    {
        $testRecord = factory($this->getModel())->create();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->get($endpoint);
        $this->assertResponseOk();
        $data = $this->getResponseData();
        $this->assertEquals($testRecord->$primaryKey, $data[$primaryKey]);
    }

    public function testStore()
    {
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $this->getStoreData());
        $this->assertResponseOk();

        // uncomment this line to debug the actual created record
        //$this->verifyCreation(["foo" => "bar"]);

        $this->seeInDatabase($this->model->getTable(), $this->getStoreData());
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->create();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->put($endpoint, $this->getUpdateData());
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $this->getUpdateData());
    }

    public function testDestroy()
    {
        $testRecord = factory($this->getModel())->create();

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $testRecord->id]);
    }

    private function verifyCreation(array $where)
    {
        $database = $this->app->make('db');
        $connection = $database->getDefaultConnection();
        $new = $database->connection($connection)->table($this->model->getTable())
            ->where($where)->first();
        var_dump($new);
    }
}
