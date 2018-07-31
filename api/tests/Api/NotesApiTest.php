<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Note;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Tests\TestCases\ApiTestCase;

class NotesApiTest extends ApiTestCase
{
    /** @var User */
    private $userModel;

    /** @var Patient */
    private $patientModel;

    protected function getModel()
    {
        return Note::class;
    }

    protected function getRoute()
    {
        return '/notes';
    }

    public function setUp()
    {
        parent::setUp();
        $this->userModel = factory(User::class)->create(['docid' => 0]);
        $this->patientModel = factory(Patient::class)->create(['docid' => $this->userModel->userid]);
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = [
            'notes' => $model->notes,
            'edited' => $model->edited,
            'editor_initials' => $model->editor_initials,
            'procedure_date' => $model->procedure_date,
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = [
            'notes' => $model->notes,
            'editor_initials' => $model->editor_initials,
            'procedure_date' => $model->procedure_date,
        ];
        return $data;
    }

    public function testStore()
    {
        $this->be($this->userModel);
        $this->be($this->patientModel, 'patient');
        $storeData = $this->getStoreData();
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $storeData);
    }

    public function testUpdate()
    {
        $this->be($this->userModel);
        $this->be($this->patientModel, 'patient');
        $testRecord = factory($this->getModel())->create([
            'docid' => $this->userModel->userid,
            'userid' => $this->userModel->userid,
            'patientid' => $this->patientModel->patientid,
        ]);
        $updateData = $this->getUpdateData();
        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;
        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeInDatabase($this->model->getTable(), $updateData);
    }
}
