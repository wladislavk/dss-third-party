<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceHistory;
use Tests\TestCases\ApiTestCase;

class InsuranceHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceHistory::class;
    }

    protected function getRoute()
    {
        return '/insurance-histories';
    }

    protected function getStoreData()
    {
        $data = factory(InsuranceHistory::class)->make()->toArray();

        $data['userid'] = 100;
        return $data;
    }

    protected function getUpdateData()
    {
        return [
            'patientid'        => 7,
            'patient_lastname' => 'test lastname',
        ];
    }

    // @todo: Restore these tests

    public function testStore()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
    }

    public function testUpdate()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
    }

    public function testDestroy()
    {
        $this->markTestSkipped('Column \'fo_paid_viewed\' does not exist in the DB');
    }
}
