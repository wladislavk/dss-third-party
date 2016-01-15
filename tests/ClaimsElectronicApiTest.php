<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ClaimsElectronicApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/claims-electronic -> Api/ApiClaimsElectronicController@store method
     * 
     */
    public function testAddClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'claimid'         => 10,
            'response'        => '{"success":true}',
            'reference_id'    => 'testId',
            'percase_date'    => Carbon::now(),
            'percase_name'    => 'test name',
            'percase_amount'  => 123.45
        ];

        $this->post('/api/v1/claims-electronic', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_electronic', ['claimid' => 10]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/claims-electronic/{id} -> Api/ApiClaimsElectronicController@update method
     * 
     */
    public function testUpdateClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimElectronicTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimElectronic::class)->create();

        $data = [
            'claimid'      => 10,
            'percase_name' => 'updated percase name'
        ];

        $this->put('/api/v1/claims-electronic/' . $claimElectronicTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_electronic', ['percase_name' => 'updated percase name']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/claims-electronic/{id} -> Api/ApiClaimsElectronicController@destroy method
     * 
     */
    public function testDeleteClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);
        $claimElectronicTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimElectronic::class)->create();

        $this->delete('/api/v1/claims-electronic/' . $claimElectronicTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_claim_electronic', ['id' => $claimElectronicTestRecord->id]);
    }
}
