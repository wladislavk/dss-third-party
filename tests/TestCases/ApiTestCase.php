<?php
namespace Tests\TestCases;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class ApiTestCase extends BaseApiTestCase
{
    const INDEX_MODEL_COUNT = 5;

    use WithoutMiddleware, DatabaseTransactions;

    /** @var Model */
    protected $model;

    /** @var Faker */
    protected $faker;

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
    abstract protected function getUpdateData();

    /**
     * @return string
     */
    protected function getRoutePrefix()
    {
        return self::ROUTE_PREFIX;
    }

    /**
     * @return string
     */
    protected function getModelKey()
    {
        return $this->model->getKeyName();
    }
    
    /**
     * @return array
     */
    protected function getStoreData()
    {
        $data = factory($this->getModel())->make();
        return $data->toArray();
    }

    /**
     * @param int $count
     * @return Model|Collection
     */
    protected function modelFactory($count = 1)
    {
        return factory($this->getModel(), $count)->create();
    }

    public function setUp()
    {
        parent::setUp();
        $modelClass = $this->getModel();
        $this->model = new $modelClass();
        $this->faker = Faker::create();
    }

    public function testIndex()
    {
        // Reset table, compatible with transactions
        $this->model->newQuery()->delete();
        $this->modelFactory(self::INDEX_MODEL_COUNT);
        $this->get($this->getRoutePrefix() . $this->getRoute());
        $this->assertResponseOk();
        $this->assertEquals(self::INDEX_MODEL_COUNT, count($this->getResponseData()));
    }

    public function testShow()
    {
        $testRecord = $this->modelFactory();

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->get($endpoint);
        $this->assertResponseOk();
        $data = $this->getResponseData();
        $this->assertEquals($testRecord->$primaryKey, $data[$primaryKey]);
    }

    public function testStore()
    {
        $storeData = $this->getStoreData();
        $this->post($this->getRoutePrefix() . $this->getRoute(), $storeData);
        $this->assertResponseOk();

        // uncomment this line to debug the actual created record
        //$this->verifyCreation(["foo" => "bar"]);

        $this->seeInDatabase($this->model->getTable(), $storeData);
    }

    public function testUpdate()
    {
        $testRecord = $this->modelFactory();

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $updateData = $this->getUpdateData();
        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $updateData);
    }

    public function testDestroy()
    {
        $testRecord = $this->modelFactory();

        $primaryKey = $this->getModelKey();
        $endpoint = $this->getRoutePrefix() . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->delete($endpoint);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $testRecord->$primaryKey]);
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
