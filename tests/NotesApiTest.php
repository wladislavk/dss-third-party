<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Note;

class NotesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/notes -> NotesController@store method
     * 
     */
    public function testAddNote()
    {
        $data = factory(Note::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/notes', $data)
            ->seeInDatabase('dental_notes', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/notes/{id} -> NotesController@update method
     * 
     */
    public function testUpdateNote()
    {
        $noteTestRecord = factory(Note::class)->create();

        $data = [
            'notes'  => 'updated notes',
            'userid' => 12
        ];

        $this->put('/api/v1/notes/' . $noteTestRecord->notesid, $data)
            ->seeInDatabase('dental_notes', ['userid' => 12])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/notes/{id} -> NotesController@destroy method
     * 
     */
    public function testDeleteNote()
    {
        $noteTestRecord = factory(Note::class)->create();

        $this->delete('/api/v1/notes/' . $noteTestRecord->notesid)
            ->notSeeInDatabase('dental_notes', [
                'notesid' => $noteTestRecord->notesid
            ])
            ->assertResponseOk();
    }
}
