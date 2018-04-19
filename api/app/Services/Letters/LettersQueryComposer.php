<?php

namespace DentalSleepSolutions\Services\Letters;

use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;

class LettersQueryComposer
{
    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(LetterRepository $letterRepository)
    {
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param array $where
     * @param array $updateData
     */
    public function updateLetterBy(array $where, array $updateData)
    {
        $query = $this->letterRepository->getUpdateLetterBaseQuery();

        foreach ($where as $key => $value) {
            $query = $this->letterRepository->getUpdateLetterCondition($query, $key, $value);
        }

        $this->letterRepository->doUpdateLetter($query, $updateData);
    }
}
