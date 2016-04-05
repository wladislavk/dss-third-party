<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\FlowsheetSegment;

class FlowsheetSegmentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/flowsheet-segments -> FlowsheetSegmentsController@store method
     * 
     */
    public function testAddFlowsheetSegment()
    {
        $data = factory(FlowsheetSegment::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/flowsheet-segments', $data)
            ->seeInDatabase('flowsheet_segments', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/flowsheet-segments/{id} -> FlowsheetSegmentsController@update method
     * 
     */
    public function testUpdateFlowsheetSegment()
    {
        $flowsheetSegmentTestRecord = factory(FlowsheetSegment::class)->create();

        $data = [
            'section' => 'updated section',
            'sortby'  => 7
        ];

        $this->put('/api/v1/flowsheet-segments/' . $flowsheetSegmentTestRecord->id, $data)
            ->seeInDatabase('flowsheet_segments', [
                'section' => 'updated section'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/flowsheet-segments/{id} -> FlowsheetSegmentsController@destroy method
     * 
     */
    public function testDeleteFlowsheetSegment()
    {
        $flowsheetSegmentTestRecord = factory(FlowsheetSegment::class)->create();

        $this->delete('/api/v1/flowsheet-segments/' . $flowsheetSegmentTestRecord->id)
            ->notSeeInDatabase('flowsheet_segments', [
                'id' => $flowsheetSegmentTestRecord->id
            ])
            ->assertResponseOk();
    }
}
