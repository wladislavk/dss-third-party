<?php
namespace Ds3\Contracts;

interface LetterTemplateInterface
{
    public function findLetterTemplate($id);
    public function insertData($data);
}
