<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="InsuranceDocument",
 *     type="object",
 *     required={"doc_insuranceid"},
 *     @SWG\Property(property="doc_insuranceid", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="video_file", type="string"),
 *     @SWG\Property(property="doc_file", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="docid", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\InsuranceDocument
 *
 * @property int $doc_insuranceid
 * @property string|null $title
 * @property string|null $description
 * @property string|null $video_file
 * @property string|null $doc_file
 * @property int|null $sortby
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $docid
 * @mixin \Eloquent
 */
class InsuranceDocument extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'video_file',
        'doc_file', 'sortby', 'status',
        'adddate', 'ip_address', 'docid'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_doc_insurance';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'doc_insuranceid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
