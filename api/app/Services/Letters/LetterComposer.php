<?php

namespace DentalSleepSolutions\Services\Letters;

use Carbon\Carbon;
use DentalSleepSolutions\Structs\LetterData;

class LetterComposer
{
    /**
     * @param LetterData $letterData
     * @return array
     */
    public function composeLetter(LetterData $letterData)
    {
        if ($letterData->toPatient !== null && !$letterData->ccToPatient) {
            $letterData->ccToPatient = $letterData->toPatient;
        }

        if ($letterData->mdList !== null && !$letterData->ccMdList) {
            $letterData->ccMdList = $letterData->mdList;
        }

        if ($letterData->mdReferralList !== null && !$letterData->ccMdReferralList) {
            $letterData->ccMdReferralList = $letterData->mdReferralList;
        }

        if ($letterData->patientReferralList !== null && !$letterData->ccPatientReferralList) {
            $letterData->ccPatientReferralList = $letterData->patientReferralList;
        }

        if ($letterData->template) {
            $regExp = '/(?:&Acirc;|&acirc;|&nbsp;)+/';
            $letterData->template = preg_replace($regExp, '', $letterData->template);
            $letterData->template = html_entity_decode(
                $letterData->template,
                ENT_COMPAT | ENT_IGNORE,
                "UTF-8"
            );
        }

        $dateSent = '';
        if ($letterData->status == true) {
            $dateSent = Carbon::now();
        }
        $letterData->dateSent = $dateSent;

        $data = $letterData->toUpdateArray();

        $parentId = $this->getParentId($letterData);
        if ($parentId !== null) {
            $data['parentid'] = $parentId;
        }

        return $data;
    }

    /**
     * @param LetterData $letterData
     * @return int|null|string
     */
    private function getParentId(LetterData $letterData)
    {
        if ($letterData->parentId && $letterData->status != true) {
            return $letterData->parentId;
        }
        if ($letterData->status == true) {
            return '';
        }
        return null;
    }

    /**
     * @param int $docId
     * @param int $templateId
     * @param int $mdList
     * @return array
     */
    public function composeWelcomeLetter($docId, $templateId, $mdList)
    {
        $data = [
            'templateid' => $templateId,
            'generated_date' => Carbon::now(),
            'delivered' => '0',
            'status' => '0',
            'deleted' => '0',
            'docid' => $docId,
            'userid' => $docId,
        ];

        if ($mdList) {
            $data['md_list'] = $mdList;
            $data['cc_md_list'] = $mdList;
        }

        return $data;
    }
}
