<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\AssessmentPlanExam;
use Tests\TestCases\ApiTestCase;

class AssessmentPlanExamsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AssessmentPlanExam::class;
    }

    protected function getRoute()
    {
        return '/assessment-plan-exams';
    }

    protected function getStoreData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'assessment_codes' => $data['assessment_codes'],
            'assessment_description' => $data['assessment_description'],
            'treatment_codes' => $data['treatment_codes'],
            'treatment_description' => $data['treatment_description'],
        ];
        return $data;
    }

    protected function getUpdateData()
    {
        $model = factory($this->getModel())->make();
        $data = $model->toArray();
        $data = [
            'assessment_codes' => $data['assessment_codes'],
            'assessment_description' => $data['assessment_description'],
            'treatment_codes' => $data['treatment_codes'],
            'treatment_description' => $data['treatment_description'],
        ];
        return $data;
    }

    public function testStore()
    {
        $storeData = $this->getStoreData();
        $jsonData = [
            'assessment_codes' => $storeData['assessment_codes'],
            'treatment_codes' => $storeData['treatment_codes'],
        ];
        $plainData = [
            'assessment_description' => $storeData['assessment_description'],
            'treatment_description' => $storeData['treatment_description'],
        ];
        $this->post(self::ROUTE_PREFIX . $this->getRoute(), $storeData);
        $this->assertResponseOk();
        $this->seeJsonInDatabase($this->model->getTable(), $jsonData);
        $this->seeInDatabase($this->model->getTable(), $plainData);
    }

    public function testUpdate()
    {
        $testRecord = factory($this->getModel())->create();
        $updateData = $this->getUpdateData();
        $jsonData = [
            'assessment_codes' => $updateData['assessment_codes'],
            'treatment_codes' => $updateData['treatment_codes'],
        ];
        $plainData = [
            'assessment_description' => $updateData['assessment_description'],
            'treatment_description' => $updateData['treatment_description'],
        ];

        $primaryKey = $this->model->getKeyName();
        $endpoint = self::ROUTE_PREFIX . $this->getRoute() . '/' . $testRecord->$primaryKey;

        $this->put($endpoint, $updateData);
        $this->assertResponseOk();
        $this->seeJsonInDatabase($this->model->getTable(), $jsonData);
        $this->seeInDatabase($this->model->getTable(), $plainData);
    }

    /**
     * @param string $table
     * @param array  $data
     */
    protected function seeJsonInDatabase($table, array $data)
    {
        foreach ($data as &$each) {
            $each = json_encode($each);
        }
        $this->seeInDatabase($table, $data);
    }
}
