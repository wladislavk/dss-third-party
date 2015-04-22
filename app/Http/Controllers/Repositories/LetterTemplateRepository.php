<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\LetterTemplateInterface;
use Ds3\Eloquent\Letter\LetterTemplate;

class LetterTemplateRepository implements LetterTemplateInterface
{
    public function findLetterTemplate($id)
    {
        return LetterTemplate::find($id);
    }

    public function insertData($data)
    {
        $letterTemplate = new LetterTemplate();

        foreach ($data as $attribute => $value) {
            $letterTemplate->$attribute = $value;
        }

        $letterTemplate->save();

        return $letterTemplate->id;
    }
}
