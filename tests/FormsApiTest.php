<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Form;

class FormsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/forms -> FormsController@store method
     * 
     */
    public function testAddForm()
    {
        $data = factory(Form::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/forms', $data)
            ->seeInDatabase('dental_forms', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/forms/{id} -> FormsController@update method
     * 
     */
    public function testUpdateForm()
    {
        $formTestRecord = factory(Form::class)->create();

        $data = [
            'formtype' => 5,
            'docid'    => 7
        ];

        $this->put('/api/v1/forms/' . $formTestRecord->formid, $data)
            ->seeInDatabase('dental_forms', [
                'formtype' => 5
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/forms/{id} -> FormsController@destroy method
     * 
     */
    public function testDeleteForm()
    {
        $formTestRecord = factory(Form::class)->create();

        $this->delete('/api/v1/forms/' . $formTestRecord->formid)
            ->notSeeInDatabase('dental_forms', [
                'formid' => $formTestRecord->formid
            ])
            ->assertResponseOk();
    }
}