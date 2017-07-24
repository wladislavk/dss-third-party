<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment;

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
}
