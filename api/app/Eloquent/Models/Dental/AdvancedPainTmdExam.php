<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="AdvancedPainTmdExam",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="patient_id", type="integer"),
 *     @SWG\Property(property="doc_id", type="integer"),
 *     @SWG\Property(property="created_by_user", type="integer"),
 *     @SWG\Property(property="created_by_admin", type="integer"),
 *     @SWG\Property(property="updated_by_user", type="integer"),
 *     @SWG\Property(property="updated_by_admin", type="integer"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(
 *         property="cervical",
 *         type="object",
 *         @SWG\Property(
 *             property="extension",
 *             type="object",
 *             @SWG\Property(property="rom", type="string"),
 *             @SWG\Property(property="pain", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="flexion",
 *             type="object",
 *             @SWG\Property(property="rom", type="string"),
 *             @SWG\Property(property="pain", type="integer")
 *         ),
 *         @SWG\Property(
 *             property="rotation",
 *             type="object",
 *             @SWG\Property(
 *                 property="right",
 *                 type="object",
 *                 @SWG\Property(property="rom", type="string"),
 *                 @SWG\Property(property="pain", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="left",
 *                 type="object",
 *                 @SWG\Property(property="rom", type="string"),
 *                 @SWG\Property(property="pain", type="integer")
 *             ),
 *             @SWG\Property(property="symmetry", type="string")
 *         ),
 *         @SWG\Property(
 *             property="side_bend",
 *             type="object",
 *             @SWG\Property(
 *                 property="right",
 *                 type="object",
 *                 @SWG\Property(property="rom", type="string"),
 *                 @SWG\Property(property="pain", type="integer")
 *             ),
 *             @SWG\Property(
 *                 property="left",
 *                 type="object",
 *                 @SWG\Property(property="rom", type="string"),
 *                 @SWG\Property(property="pain", type="integer")
 *             ),
 *             @SWG\Property(property="symmetry", type="string")
 *         )
 *     ),
 *     @SWG\Property(
 *         property="morphology",
 *         type="object",
 *         @SWG\Property(
 *             property="midline",
 *             type="object",
 *             @SWG\Property(
 *                 property="general",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="facial",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="teeth",
 *                 type="object",
 *                 @SWG\Property(
 *                     property="maxila",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string")
 *                 ),
 *                 @SWG\Property(
 *                     property="mandible",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string")
 *                 )
 *             ),
 *             @SWG\Property(
 *                 property="eyes",
 *                 type="object",
 *                 @SWG\Property(
 *                     property="right",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string")
 *                 ),
 *                 @SWG\Property(
 *                     property="left",
 *                     type="object",
 *                     @SWG\Property(property="position", type="string")
 *                 )
 *             )
 *         ),
 *         @SWG\Property(
 *             property="posture",
 *             type="object",
 *             @SWG\Property(
 *                 property="head",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="standing",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string")
 *             ),
 *             @SWG\Property(
 *                 property="sitting",
 *                 type="object",
 *                 @SWG\Property(property="position", type="string")
 *             )
 *         ),
 *         @SWG\Property(
 *             property="shoulders",
 *             type="object",
 *             @SWG\Property(property="position", type="string")
 *         ),
 *         @SWG\Property(
 *             property="hips",
 *             type="object",
 *             @SWG\Property(property="position", type="string")
 *         ),
 *         @SWG\Property(
 *             property="spine",
 *             type="object",
 *             @SWG\Property(property="position", type="string")
 *         ),
 *         @SWG\Property(
 *             property="pupillary_plane",
 *             type="object",
 *             @SWG\Property(property="position", type="string")
 *         )
 *     ),
 *     @SWG\Property(
 *         property="cranial_nerve",
 *         type="object",
 *         @SWG\Property(property="olfactory", type="boolean"),
 *         @SWG\Property(property="optic", type="boolean"),
 *         @SWG\Property(property="occulomotor", type="boolean"),
 *         @SWG\Property(property="trochlear", type="boolean"),
 *         @SWG\Property(property="trigeminal", type="boolean"),
 *         @SWG\Property(property="abducens", type="boolean"),
 *         @SWG\Property(property="facial", type="boolean"),
 *         @SWG\Property(property="acoustic", type="boolean"),
 *         @SWG\Property(property="glossopharyngeal", type="boolean"),
 *         @SWG\Property(property="vagus", type="boolean"),
 *         @SWG\Property(property="accessory", type="boolean"),
 *         @SWG\Property(property="hypoglossal", type="boolean")
 *     ),
 *     @SWG\Property(
 *         property="occlusal",
 *         type="object",
 *         @SWG\Property(
 *             property="contacts",
 *             type="object",
 *             @SWG\Property(
 *                 property="working",
 *                 type="object",
 *                 @SWG\Property(property="right", type="array"),
 *                 @SWG\Property(property="left", type="array")
 *             ),
 *             @SWG\Property(
 *                 property="non_working",
 *                 type="object",
 *                 @SWG\Property(property="right", type="array"),
 *                 @SWG\Property(property="left", type="array")
 *             )
 *         ),
 *         @SWG\Property(property="crossover_interferences", type="array")
 *     ),
 *     @SWG\Property(
 *         property="other",
 *         type="object",
 *         @SWG\Property(property="guidance", type="string"),
 *         @SWG\Property(property="notes", type="string")
 *     ),
 *     @SWG\Property(property="created_at", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\AdvancedPainTmdExam
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int|null $doc_id
 * @property int|null $created_by_user
 * @property int|null $created_by_admin
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property string|null $ip_address
 * @property array|null $cervical
 * @property array|null $morphology
 * @property array|null $cranial_nerve
 * @property array|null $occlusal
 * @property array|null $other
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AdvancedPainTmdExam extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'cervical',
        'morphology',
        'cranial_nerve',
        'occlusal',
        'other',
    ];

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_advanced_pain_tmd_exams';

    /**
     * @return array|null
     */
    public function getCervicalAttribute()
    {
        return json_decode($this->getAttributeFromArray('cervical'), true);
    }

    /**
     * @param array $value
     */
    public function setCervicalAttribute(array $value = null)
    {
        $this->attributes['cervical'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getMorphologyAttribute()
    {
        return json_decode($this->getAttributeFromArray('morphology'), true);
    }

    /**
     * @param array $value
     */
    public function setMorphologyAttribute(array $value = null)
    {
        $this->attributes['morphology'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getCranialNerveAttribute()
    {
        return json_decode($this->getAttributeFromArray('cranial_nerve'), true);
    }

    /**
     * @param array $value
     */
    public function setCranialNerveAttribute(array $value = null)
    {
        $this->attributes['cranial_nerve'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getOcclusalAttribute()
    {
        return json_decode($this->getAttributeFromArray('occlusal'), true);
    }

    /**
     * @param array $value
     */
    public function setOcclusalAttribute(array $value = null)
    {
        $this->attributes['occlusal'] = json_encode($value);
    }

    /**
     * @return array|null
     */
    public function getOtherAttribute()
    {
        return json_decode($this->getAttributeFromArray('other'), true);
    }

    /**
     * @param array $value
     */
    public function setOtherAttribute(array $value = null)
    {
        $this->attributes['other'] = json_encode($value);
    }
}
