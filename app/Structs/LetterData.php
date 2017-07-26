<?php

namespace DentalSleepSolutions\Structs;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class LetterData implements Arrayable
{
    /** @var int */
    public $patientId;

    /** @var int */
    public $infoId;

    /** @var bool */
    public $toPatient;

    /** @var string */
    public $mdList;

    /** @var string */
    public $mdReferralList;

    /** @var string */
    public $patientReferralList;

    /** @var int */
    public $parentId;

    /** @var string */
    public $template;

    /** @var int */
    public $templateId;

    /** @var string */
    public $sendMethod;

    /** @var bool */
    public $status;

    /** @var bool */
    public $deleted = false;

    /** @var bool */
    public $checkRecipient;

    /** @var bool */
    public $templateType;

    /** @var bool */
    public $ccToPatient;

    /** @var string */
    public $ccMdList;

    /** @var string */
    public $ccMdReferralList;

    /** @var string */
    public $ccPatientReferralList;

    /** @var int */
    public $fontSize;

    /** @var string */
    public $fontFamily;

    /** @var int */
    public $userId;

    /** @var int */
    public $docId;

    /** @var int */
    public $deletedBy;

    /** @var Carbon */
    public $deletedOn;

    public function toArray()
    {
        return [
            'patientid' => $this->patientId,
            'send_method' => $this->sendMethod,
            'template' => $this->template,
            'templateid' => $this->templateId,
            'template_type' => $this->templateType,
            'status' => $this->status,
            'deleted' => $this->deleted,
            'deleted_by' => $this->deletedBy,
            'deleted_on' => $this->deletedOn,
            'parentid' => $this->parentId,
            'topatient' => $this->toPatient,
            'cc_topatient' => $this->ccToPatient,
            'md_list' => $this->mdList,
            'md_referral_list' => $this->mdReferralList,
            'docid' => $this->docId,
            'userid' => $this->userId,
            'info_id' => $this->infoId,
            'cc_md_list' => $this->ccMdList,
            'cc_md_referral_list' => $this->ccMdReferralList,
            'font_family' => $this->fontFamily,
            'font_size' => $this->fontSize,
            'pat_referral_list' => $this->patientReferralList,
            'cc_pat_referral_list' => $this->ccPatientReferralList,
        ];
    }
}
