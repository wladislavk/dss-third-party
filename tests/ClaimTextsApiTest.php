<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ClaimTextsApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/claim-texts -> Api/ApiClaimTextsController@store method
     * 
     */
    public function testAddClaimText()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'title'        => 'test',
            'description'  => 'test description',
            'default_text' => 1,
            'companyid'    => 1
        ];

        $this->post('/api/v1/claim-texts', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_text', ['description' => 'test description']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/claim-texts/{id} -> Api/ApiClaimTextsController@update method
     * 
     */
    public function testUpdateClaimText()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimTextTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimText::class)->create();

        $data = [
            'description' => 'updated test description'
        ];

        $this->put('/api/v1/claim-texts/' . $claimTextTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_text', ['description' => 'updated test description']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/claim-texts/{id} -> Api/ApiClaimTextsController@destroy method
     * 
     */
    public function testDeleteClaimText()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimTextTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimText::class)->create();

        $this->delete('/api/v1/claim-texts/' . $claimTextTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_claim_text', ['id' => $claimTextTestRecord->id]);
    }
}
