<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate;

class CustomLetterTemplatesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/custom-letter-templates -> CustomLetterTemplatesController@store method
     * 
     */
    public function testAddCustomLetterTemplate()
    {
        $data = factory(CustomLetterTemplate::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/custom-letter-templates', $data)
            ->seeInDatabase('dental_letter_templates_custom', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/custom-letter-templates/{id} -> CustomLetterTemplatesController@update method
     * 
     */
    public function testUpdateCustomLetterTemplate()
    {
        $customLetterTemplateTestRecord = factory(CustomLetterTemplate::class)->create();

        $data = [
            'name'   => 'updated name',
            'status' => 8
        ];

        $this->put('/api/v1/custom-letter-templates/' . $customLetterTemplateTestRecord->id, $data)
            ->seeInDatabase('dental_letter_templates_custom', [
                'name' => 'updated name'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/custom-letter-templates/{id} -> CustomLetterTemplatesController@destroy method
     * 
     */
    public function testDeleteCustomLetterTemplate()
    {
        $customLetterTemplateTestRecord = factory(CustomLetterTemplate::class)->create();

        $this->delete('/api/v1/custom-letter-templates/' . $customLetterTemplateTestRecord->id)
            ->notSeeInDatabase('dental_letter_templates_custom', [
                'id' => $customLetterTemplateTestRecord->id
            ])
            ->assertResponseOk();
    }
}
