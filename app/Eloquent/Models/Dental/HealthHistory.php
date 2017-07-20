<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="HealthHistory",
 *     type="object",
 *     required={"q_page3id", "injurytohead", "injurytoneck", "injurytoface", "injurytoteeth", "injurytomouth", "drymouth", "jawjointsurgery"},
 *     @SWG\Property(property="q_page3id", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="allergens", type="string"),
 *     @SWG\Property(property="other_allergens", type="string"),
 *     @SWG\Property(property="medications", type="string"),
 *     @SWG\Property(property="other_medications", type="string"),
 *     @SWG\Property(property="history", type="string"),
 *     @SWG\Property(property="other_history", type="string"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="dental_health", type="string"),
 *     @SWG\Property(property="removable", type="string"),
 *     @SWG\Property(property="year_completed", type="string"),
 *     @SWG\Property(property="tmj", type="string"),
 *     @SWG\Property(property="gum_problems", type="string"),
 *     @SWG\Property(property="dental_pain", type="string"),
 *     @SWG\Property(property="dental_pain_describe", type="string"),
 *     @SWG\Property(property="completed_future", type="string"),
 *     @SWG\Property(property="clinch_grind", type="string"),
 *     @SWG\Property(property="wisdom_extraction", type="string"),
 *     @SWG\Property(property="injurytohead", type="string"),
 *     @SWG\Property(property="injurytoneck", type="string"),
 *     @SWG\Property(property="injurytoface", type="string"),
 *     @SWG\Property(property="injurytoteeth", type="string"),
 *     @SWG\Property(property="injurytomouth", type="string"),
 *     @SWG\Property(property="drymouth", type="string"),
 *     @SWG\Property(property="jawjointsurgery", type="string"),
 *     @SWG\Property(property="no_allergens", type="string"),
 *     @SWG\Property(property="no_medications", type="string"),
 *     @SWG\Property(property="no_history", type="string"),
 *     @SWG\Property(property="orthodontics", type="string"),
 *     @SWG\Property(property="wisdom_extraction_text", type="string"),
 *     @SWG\Property(property="removable_text", type="string"),
 *     @SWG\Property(property="dentures", type="string"),
 *     @SWG\Property(property="dentures_text", type="string"),
 *     @SWG\Property(property="tmj_cp", type="string"),
 *     @SWG\Property(property="tmj_cp_text", type="string"),
 *     @SWG\Property(property="tmj_pain", type="string"),
 *     @SWG\Property(property="tmj_pain_text", type="string"),
 *     @SWG\Property(property="tmj_surgery", type="string"),
 *     @SWG\Property(property="tmj_surgery_text", type="string"),
 *     @SWG\Property(property="injury", type="string"),
 *     @SWG\Property(property="injury_text", type="string"),
 *     @SWG\Property(property="gum_prob", type="string"),
 *     @SWG\Property(property="gum_prob_text", type="string"),
 *     @SWG\Property(property="gum_surgery", type="string"),
 *     @SWG\Property(property="gum_surgery_text", type="string"),
 *     @SWG\Property(property="clinch_grind_text", type="string"),
 *     @SWG\Property(property="future_dental_det", type="string"),
 *     @SWG\Property(property="drymouth_text", type="string"),
 *     @SWG\Property(property="family_hd", type="string"),
 *     @SWG\Property(property="family_bp", type="string"),
 *     @SWG\Property(property="family_dia", type="string"),
 *     @SWG\Property(property="family_sd", type="string"),
 *     @SWG\Property(property="alcohol", type="string"),
 *     @SWG\Property(property="sedative", type="string"),
 *     @SWG\Property(property="caffeine", type="string"),
 *     @SWG\Property(property="smoke", type="string"),
 *     @SWG\Property(property="smoke_packs", type="string"),
 *     @SWG\Property(property="tobacco", type="string"),
 *     @SWG\Property(property="additional_paragraph", type="string"),
 *     @SWG\Property(property="allergenscheck", type="integer"),
 *     @SWG\Property(property="medicationscheck", type="integer"),
 *     @SWG\Property(property="historycheck", type="integer"),
 *     @SWG\Property(property="parent_patientid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\HealthHistory
 *
 * @property int $q_page3id
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $allergens
 * @property string|null $other_allergens
 * @property string|null $medications
 * @property string|null $other_medications
 * @property string|null $history
 * @property string|null $other_history
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $dental_health
 * @property string|null $removable
 * @property string|null $year_completed
 * @property string|null $tmj
 * @property string|null $gum_problems
 * @property string|null $dental_pain
 * @property string|null $dental_pain_describe
 * @property string|null $completed_future
 * @property string|null $clinch_grind
 * @property string|null $wisdom_extraction
 * @property string $injurytohead
 * @property string $injurytoneck
 * @property string $injurytoface
 * @property string $injurytoteeth
 * @property string $injurytomouth
 * @property string $drymouth
 * @property string $jawjointsurgery
 * @property string|null $no_allergens
 * @property string|null $no_medications
 * @property string|null $no_history
 * @property string|null $orthodontics
 * @property string|null $wisdom_extraction_text
 * @property string|null $removable_text
 * @property string|null $dentures
 * @property string|null $dentures_text
 * @property string|null $tmj_cp
 * @property string|null $tmj_cp_text
 * @property string|null $tmj_pain
 * @property string|null $tmj_pain_text
 * @property string|null $tmj_surgery
 * @property string|null $tmj_surgery_text
 * @property string|null $injury
 * @property string|null $injury_text
 * @property string|null $gum_prob
 * @property string|null $gum_prob_text
 * @property string|null $gum_surgery
 * @property string|null $gum_surgery_text
 * @property string|null $clinch_grind_text
 * @property string|null $future_dental_det
 * @property string|null $drymouth_text
 * @property string|null $family_hd
 * @property string|null $family_bp
 * @property string|null $family_dia
 * @property string|null $family_sd
 * @property string|null $alcohol
 * @property string|null $sedative
 * @property string|null $caffeine
 * @property string|null $smoke
 * @property string|null $smoke_packs
 * @property string|null $tobacco
 * @property string|null $additional_paragraph
 * @property int|null $allergenscheck
 * @property int|null $medicationscheck
 * @property int|null $historycheck
 * @property int|null $parent_patientid
 * @mixin \Eloquent
 */
class HealthHistory extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['q_page3id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_page3';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'q_page3id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }
}
