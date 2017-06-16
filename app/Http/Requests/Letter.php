<?php

namespace DentalSleepSolutions\Http\Requests;

class Letter extends Request
{
    public function destroyRules()
    {
        return [
            // @todo Provide validation rules
        ];
    }

    public function storeRules()
    {
        return [
            'patientid'            => 'required|integer',
            'stepid'               => 'integer',
            'delivery_date'        => 'date',
            'send_method'          => 'string',
            'template'             => 'string',
            'pdf_path'             => 'string',
            'status'               => 'integer',
            'delivered'            => 'integer',
            'deleted'              => 'boolean',
            'templateid'           => 'integer',
            'parentid'             => 'integer',
            'topatient'            => 'boolean',
            'md_list'              => 'string',
            'md_referral_list'     => 'string',
            'docid'                => 'required|integer',
            'userid'               => 'required|integer',
            'date_sent'            => 'date',
            'info_id'              => 'integer',
            'edit_userid'          => 'integer',
            'mailed_date'          => 'date',
            'mailed_once'          => 'integer',
            'template_type'        => 'integer',
            'cc_topatient'         => 'integer',
            'cc_md_list'           => 'string',
            'cc_md_referral_list'  => 'string',
            'font_family'          => 'string',
            'font_size'            => 'integer',
            'pat_referral_list'    => 'string',
            'cc_pat_referral_list' => 'string',
            'deleted_by'           => 'integer',
            'deleted_on'           => 'date'
        ];
    }

    public function updateRules()
    {
        return [
            'patientid'            => 'sometimes|required|integer',
            'stepid'               => 'integer',
            'delivery_date'        => 'date',
            'send_method'          => 'string',
            'template'             => 'string',
            'pdf_path'             => 'string',
            'status'               => 'integer',
            'delivered'            => 'integer',
            'deleted'              => 'boolean',
            'templateid'           => 'integer',
            'parentid'             => 'integer',
            'topatient'            => 'boolean',
            'md_list'              => 'string',
            'md_referral_list'     => 'string',
            'docid'                => 'sometimes|required|integer',
            'userid'               => 'sometimes|required|integer',
            'date_sent'            => 'date',
            'info_id'              => 'integer',
            'edit_userid'          => 'integer',
            'mailed_date'          => 'date',
            'mailed_once'          => 'integer',
            'template_type'        => 'integer',
            'cc_topatient'         => 'integer',
            'cc_md_list'           => 'string',
            'cc_md_referral_list'  => 'string',
            'font_family'          => 'string',
            'font_size'            => 'integer',
            'pat_referral_list'    => 'string',
            'cc_pat_referral_list' => 'string',
            'deleted_by'           => 'integer',
            'deleted_on'           => 'date'
        ];
    }
}
