<?php

namespace DentalSleepSolutions\Structs;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class LetterData implements Arrayable
{
    /** @var int */
    public $patientId = 0;

    /** @var int */
    public $infoId = 0;

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

    /** @var Carbon|string */
    public $dateSent;

    public function toArray()
    {
        return [
            'cc_md_list' => $this->ccMdList,
            'cc_md_referral_list' => $this->ccMdReferralList,
            'cc_pat_referral_list' => $this->ccPatientReferralList,
            'cc_topatient' => $this->ccToPatient,
            'deleted' => $this->deleted,
            'deleted_by' => $this->deletedBy,
            'deleted_on' => $this->deletedOn,
            'docid' => $this->docId,
            'font_family' => $this->fontFamily,
            'font_size' => $this->fontSize,
            'info_id' => $this->infoId,
            'md_list' => $this->mdList,
            'md_referral_list' => $this->mdReferralList,
            'parentid' => $this->parentId,
            'patientid' => $this->patientId,
            'pat_referral_list' => $this->patientReferralList,
            'send_method' => $this->sendMethod,
            'status' => $this->status,
            'template' => $this->template,
            'templateid' => $this->templateId,
            'template_type' => $this->templateType,
            'topatient' => $this->toPatient,
            'userid' => $this->userId,
        ];
    }

    public function toUpdateArray()
    {
        return [
            'cc_md_list'           => $this->ccMdList,
            'cc_md_referral_list'  => $this->ccMdReferralList,
            'cc_pat_referral_list' => $this->ccPatientReferralList,
            'cc_topatient' => $this->ccToPatient,
            'date_sent'            => $this->dateSent,
            'deleted'              => $this->deleted,
            'deleted_by'           => $this->userId,
            'deleted_on'           => Carbon::now(),
            'delivered'            => '0',
            'docid'                => $this->docId,
            'font_family'          => $this->fontFamily,
            'font_size'            => $this->fontSize,
            'generated_date'       => Carbon::now(),
            'info_id'              => $this->infoId,
            'md_list'              => $this->mdList,
            'md_referral_list'     => $this->mdReferralList,
            'patientid'            => $this->patientId,
            'pat_referral_list'    => $this->patientReferralList,
            'send_method'          => $this->sendMethod,
            'status'               => $this->status,
            'template' => $this->template,
            'templateid'           => $this->templateId,
            'template_type'        => $this->templateType,
            'topatient'            => $this->toPatient,
            'userid'               => $this->userId,
        ];
    }
}
