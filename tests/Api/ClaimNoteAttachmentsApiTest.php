<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNoteAttachment;

class ClaimNoteAttachmentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ClaimNoteAttachment::class;
    }

    protected function getRoute()
    {
        return '/claim-note-attachments';
    }

    protected function getStoreData()
    {
        return [
            'note_id'  => 5,
            'filename' => 'testFilename',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'filename' => 'updatedTestFilename',
        ];
    }

    public function testIndexWithMultipleModels()
    {
        // Truncate, compatible with transactions
        $this->model->newQuery()->delete();
        // List more than one model
        factory($this->getModel(), 5)->create();
        $this->get(self::ROUTE_PREFIX . $this->getRoute());
        $this->assertResponseOk();
        $this->assertEquals(5, count($this->getResponseData()));
    }
}
