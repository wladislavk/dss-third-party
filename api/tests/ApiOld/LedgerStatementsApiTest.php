<?php
namespace Tests\ApiOld;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\LedgerStatement;

class LedgerStatementsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LedgerStatement::class;
    }

    protected function getRoute()
    {
        return '/ledger-statements';
    }

    protected function getStoreData()
    {
        return [
            "producerid" => 100,
            "filename" => "/manage/letterpdfs/statement_4238_1249456.pdf",
            "patientid" => 4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'  => 50,
            'producerid' => 40,
        ];
    }

    public function testRemoveByIdAndPatientId()
    {
        /** @var LedgerStatement $testRecord */
        $testRecord = factory($this->getModel())->create();
        $testRecord->patientid = 1;
        $testRecord->save();
        $primaryKey = $this->model->getKeyName();
        $id = $testRecord->$primaryKey;

        $this->post(self::ROUTE_PREFIX . '/ledger-statements/remove', ['id' => $id, 'patient_id' => 1]);
        $this->assertResponseOk();
        $this->notSeeInDatabase($this->model->getTable(), [$primaryKey => $id]);
    }
}
