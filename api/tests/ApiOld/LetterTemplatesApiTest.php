<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\LetterTemplate;
use Tests\TestCases\ApiTestCase;

class LetterTemplatesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return LetterTemplate::class;
    }

    protected function getRoute()
    {
        return '/letter-templates';
    }

    protected function getStoreData()
    {
        return [
            "name" => "Ut sequi cupiditate eum aut.",
            "template" => "/manage/gy_h.php",
            "body" => "Quia tenetur quos magni qui eos corrupti beatae.",
            "default_letter" => 9,
            "companyid" => 100,
            "triggerid" => 0,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'body'      => 'updated body',
            'triggerid' => 8,
        ];
    }
}
