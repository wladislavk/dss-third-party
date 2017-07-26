<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="Letter",
 *     type="object",
 *     required={"letterid"},
 *     @SWG\Property(property="letterid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="stepid", type="integer"),
 *     @SWG\Property(property="generated_date", type="string", format="dateTime"),
 *     @SWG\Property(property="delivery_date", type="string", format="dateTime"),
 *     @SWG\Property(property="send_method", type="string"),
 *     @SWG\Property(property="template", type="string"),
 *     @SWG\Property(property="pdf_path", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="delivered", type="integer"),
 *     @SWG\Property(property="deleted", type="integer"),
 *     @SWG\Property(property="templateid", type="integer"),
 *     @SWG\Property(property="parentid", type="integer"),
 *     @SWG\Property(property="topatient", type="integer"),
 *     @SWG\Property(property="md_list", type="string"),
 *     @SWG\Property(property="md_referral_list", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="date_sent", type="string", format="dateTime"),
 *     @SWG\Property(property="info_id", type="integer"),
 *     @SWG\Property(property="edit_userid", type="integer"),
 *     @SWG\Property(property="edit_date", type="string", format="dateTime"),
 *     @SWG\Property(property="mailed_date", type="string", format="dateTime"),
 *     @SWG\Property(property="mailed_once", type="integer"),
 *     @SWG\Property(property="template_type", type="integer"),
 *     @SWG\Property(property="cc_topatient", type="integer"),
 *     @SWG\Property(property="cc_md_list", type="string"),
 *     @SWG\Property(property="cc_md_referral_list", type="string"),
 *     @SWG\Property(property="font_family", type="string"),
 *     @SWG\Property(property="font_size", type="integer"),
 *     @SWG\Property(property="pat_referral_list", type="string"),
 *     @SWG\Property(property="cc_pat_referral_list", type="string"),
 *     @SWG\Property(property="deleted_by", type="integer"),
 *     @SWG\Property(property="deleted_on", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Letter
 *
 * @property int $letterid
 * @property int|null $patientid
 * @property int|null $stepid
 * @property \Carbon\Carbon|null $generated_date
 * @property \Carbon\Carbon|null $delivery_date
 * @property string|null $send_method
 * @property string|null $template
 * @property string|null $pdf_path
 * @property int|null $status
 * @property int|null $delivered
 * @property int|null $deleted
 * @property int|null $templateid
 * @property int|null $parentid
 * @property int|null $topatient
 * @property string|null $md_list
 * @property string|null $md_referral_list
 * @property int|null $docid
 * @property int|null $userid
 * @property \Carbon\Carbon|null $date_sent
 * @property int|null $info_id
 * @property int|null $edit_userid
 * @property \Carbon\Carbon|null $edit_date
 * @property \Carbon\Carbon|null $mailed_date
 * @property int|null $mailed_once
 * @property int|null $template_type
 * @property int|null $cc_topatient
 * @property string|null $cc_md_list
 * @property string|null $cc_md_referral_list
 * @property string|null $font_family
 * @property int|null $font_size
 * @property string|null $pat_referral_list
 * @property string|null $cc_pat_referral_list
 * @property int|null $deleted_by
 * @property \Carbon\Carbon|null $deleted_on
 * @mixin \Eloquent
 */
class Letter extends AbstractModel
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['letterid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_letters';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'letterid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'delivery_date',
        'date_sent',
        'mailed_date',
        'deleted_on',
    ];

    const CREATED_AT = 'generated_date';
    const UPDATED_AT = 'edit_date';
}
