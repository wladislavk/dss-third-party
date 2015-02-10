<?php namespace Ds3\Contracts;

interface LetterTemplateInterface
{
	public function get($id);

	public function insertData($data);
}