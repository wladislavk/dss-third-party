<?php namespace Ds3\Repositories;

use Ds3\Contracts\LetterInterface;
use Ds3\Eloquent\Letter\Letter;

class LetterRepository implements LetterInterface
{
	public function get($where, $order = null)
	{
		$letters = new Letter();

		foreach ($where as $attribute => $value) {
			$letters = $letters->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$letters = $letters->orderBy($order);
		}

		return $letters->get();
	}

	public function getList($letterId, $parentId)
	{
		$letters = Letter::select(DB::raw('md_list, md_referral_list'))
				->where('letterid', '=', $letterId)
				->orWhere('parentid', '=', $parentId)
				->orderBy('letterid')
				->get();

		return $letters;
	}

	public function getMdList($contact, $letter1id, $letter2id)
	{
		$mdList = Letter::select('md_list')
				->whereRaw('md_list IS NOT NULL')
				->whereRaw("CONCAT(',', md_list, ',') LIKE CONCAT('%,', '" . $contact . "', ',%')")
				->whereRaw('templateid IN(' . $letter1id . ',' . $letter2id . ')')
				->get();

		return $mdList;						   
	}

	public function getGeneratedDates($where)
	{
		$generatedDates = Letter::leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid');

		foreach ($where as $key => $value) {
			$generatedDates = $generatedDates->where($key, '=', $value);
		}

		$generatedDates = $generatedDates->where(function($query)
						{
							$query->whereNull('dental_letters.parentid')
							  	  ->orWhere('dental_letters.parentid', '=', '0');
						})
						->orderBy('generated_date', 'asc')
						->get();

		return $generatedDates;
	}

	public function getUnmailedLetters($docId)
	{
		$unmailedLetters = Letter::leftJoin('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
						->where(function($query)
						{
							$query->where('dental_letters.status', '=', '1')
							  	  ->orWhere('dental_letters.delivered', '=', '1');
						})
						->whereNull('mailed_date')
						->where('dental_letters.deleted', '=', '0')
						->where('dental_letters.docid', '=', $docId)
						->get();

		return $unmailedLetters;
	}

	public function getJoin($patientId, $infoId)
	{
		$letter = Letter::select(DB::raw('topatient, md_list, md_referral_list, status'))
				->leftJoin('dental_letter_templates', 'dental_letters.templateid', '=', 'dental_letter_templates.id')
				->where('patientid', '=', $patientId)
				->where('info_id', '=', $infoId)
				->where('deleted', '=', 0)
				->orderBy('stepid')
				->get();

		return $letter;
	}

	public function getPendingLetters($docId, $patientId)
	{
		$letters = Letter::select('letterid')
				->join('dental_patients', 'dental_letters.patientid', '=', 'dental_patients.patientid')
				->where('dental_letters.status', '=', '0')
				->where('dental_letters.deleted', '=', '0')
				->where('dental_patients.docid', '=', $docId)
				->where('dental_letters.patientid', '=', $patientId)
				->get();

		return $letters;
	}

	public function updateData($where, $values)
	{
		$letter = new Letter();

		foreach ($where as $attribute => $value) {
			$letter = $letter->where($attribute, '=', $value);
		}
		
		$letter = $letter->update($values);

		return $letter;
	}
}