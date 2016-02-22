<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LetterTemplate;

class LetterTemplatesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/letter-templates -> LetterTemplatesController@store method
     * 
     */
    public function testAddLetterTemplate()
    {
        $data = factory(LetterTemplate::class)->make()->toArray();

        $data['companyid'] = 100;

        $this->post('/api/v1/letter-templates', $data)
            ->seeInDatabase('dental_letter_templates', ['companyid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/letter-templates/{id} -> LetterTemplatesController@update method
     * 
     */
    public function testUpdateLetterTemplate()
    {
        $letterTemplateTestRecord = factory(LetterTemplate::class)->create();

        $data = [
            'body'      => 'updated body',
            'triggerid' => 8
        ];

        $this->put('/api/v1/letter-templates/' . $letterTemplateTestRecord->id, $data)
            ->seeInDatabase('dental_letter_templates', [
                'body' => 'updated body'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/letter-templates/{id} -> LetterTemplatesController@destroy method
     * 
     */
    public function testDeleteLetterTemplate()
    {
        $letterTemplateTestRecord = factory(LetterTemplate::class)->create();

        $this->delete('/api/v1/letter-templates/' . $letterTemplateTestRecord->id)
            ->notSeeInDatabase('dental_letter_templates', [
                'id' => $letterTemplateTestRecord->id
            ])
            ->assertResponseOk();
    }
}
