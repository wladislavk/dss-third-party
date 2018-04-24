<?php

namespace DentalSleepSolutions\Services\Letters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;

class LetterModelTransformer
{
    /**
     * @param Letter[]|iterable $letters
     * @return array
     */
    public function transformLetters(iterable $letters): array
    {
        $transformed = [];
        foreach ($letters as $letter) {
            $newElement = $letter->toArray();
            $newElement['md_list'] = $this->transformProperty($letter->md_list);
            $newElement['md_referral_list'] = $this->transformProperty($letter->md_referral_list);
            $newElement['cc_md_list'] = $this->transformProperty($letter->cc_md_list);
            $newElement['cc_md_referral_list'] = $this->transformProperty($letter->cc_md_referral_list);
            $newElement['pat_referral_list'] = $this->transformProperty($letter->pat_referral_list);
            $newElement['cc_pat_referral_list'] = $this->transformProperty($letter->cc_pat_referral_list);
            $transformed[] = $newElement;
        }
        return $transformed;
    }

    /**
     * @param null|string $property
     * @return int[]
     */
    private function transformProperty(?string $property): array
    {
        if (!$property) {
            return [];
        }
        $exploded = explode(',', $property);
        array_walk($exploded, function ($TElement) {
            return (int)$TElement;
        });
        return $exploded;
    }
}
