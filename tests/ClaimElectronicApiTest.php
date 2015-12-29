<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ClaimElectronicApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/claim-electronic -> Api/ApiClaimElectronicController@store method
     * 
     */
    public function testAddClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'claimid'         => 7,
            'response'        => 'test_response',
            'adddate'         => Carbon::now(),
            'reference_id'    => 'test_reference_id',
            'percase_date'    => Carbon::now(),
            'percase_name'    => 'test_percase_name',
            'percase_amount'  => 11.22,
            'percase_status'  => 9,
            'percase_invoice' => 6,
            'percase_free'    => 5
        ];

        $this->post('/api/v1/claim-electronic', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_electronic', ['claimid' => 7]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/claim-electronic/{id} -> Api/ApiClaimElectronicController@update method
     * 
     */
    public function testUpdateClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimElectronicTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimElectronic::class)->create();

        $data = [
            'claimid'      => 15,
            'percase_name' => 'UpdateTest_percase_name'
        ];

        $this->put('/api/v1/claim-electronic/' . $claimElectronicTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_electronic', ['percase_name' => 'UpdateTest_percase_name']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/claim-electronic/{id} -> Api/ApiClaimElectronicController@destroy method
     * 
     */
    public function testDeleteClaimElectronic()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);
        $claimElectronicTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimElectronic::class)->create();

        $this->delete('/api/v1/claim-electronic/' . $claimElectronicTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_claim_electronic', ['id' => $claimElectronicTestRecord->id]);
    }
}
