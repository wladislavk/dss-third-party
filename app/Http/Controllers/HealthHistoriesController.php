<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\HealthHistories;
use Illuminate\Http\Request;

class HealthHistoriesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/health-histories",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/HealthHistory"))
     *                 )
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/health-histories/{health_histories}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/HealthHistory"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/health-histories",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="other_allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="medications", in="formData", type="string"),
     *     @SWG\Parameter(name="other_medications", in="formData", type="string"),
     *     @SWG\Parameter(name="history", in="formData", type="string"),
     *     @SWG\Parameter(name="other_history", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="dental_health", in="formData", type="string", pattern="^(?:Good|Excellent|Fair|Poor)$"),
     *     @SWG\Parameter(name="removable", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="year_completed", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_problems", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain_describe", in="formData", type="string"),
     *     @SWG\Parameter(name="completed_future", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="clinch_grind", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytohead", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoneck", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoface", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoteeth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytomouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="drymouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="jawjointsurgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="no_allergens", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_medications", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_history", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="orthodontics", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction_text", in="formData", type="string"),
     *     @SWG\Parameter(name="removable_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dentures", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="dentures_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_cp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_cp_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_pain", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_pain_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="injury", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injury_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_prob", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_prob_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="clinch_grind_text", in="formData", type="string"),
     *     @SWG\Parameter(name="future_dental_det", in="formData", type="string"),
     *     @SWG\Parameter(name="drymouth_text", in="formData", type="string"),
     *     @SWG\Parameter(name="family_hd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_bp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_dia", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_sd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="allergenscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicationscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="historycheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/HealthHistory"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Post(
     *     path="/health-histories",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="other_allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="medications", in="formData", type="string"),
     *     @SWG\Parameter(name="other_medications", in="formData", type="string"),
     *     @SWG\Parameter(name="history", in="formData", type="string"),
     *     @SWG\Parameter(name="other_history", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="dental_health", in="formData", type="string", pattern="^(?:Good|Excellent|Fair|Poor)$"),
     *     @SWG\Parameter(name="removable", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="year_completed", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_problems", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain_describe", in="formData", type="string"),
     *     @SWG\Parameter(name="completed_future", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="clinch_grind", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytohead", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoneck", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoface", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoteeth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytomouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="drymouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="jawjointsurgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="no_allergens", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_medications", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_history", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="orthodontics", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction_text", in="formData", type="string"),
     *     @SWG\Parameter(name="removable_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dentures", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="dentures_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_cp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_cp_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_pain", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_pain_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="injury", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injury_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_prob", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_prob_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="clinch_grind_text", in="formData", type="string"),
     *     @SWG\Parameter(name="future_dental_det", in="formData", type="string"),
     *     @SWG\Parameter(name="drymouth_text", in="formData", type="string"),
     *     @SWG\Parameter(name="family_hd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_bp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_dia", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_sd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="allergenscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicationscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="historycheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/HealthHistory"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/health-histories/{health_histories}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="other_allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="medications", in="formData", type="string"),
     *     @SWG\Parameter(name="other_medications", in="formData", type="string"),
     *     @SWG\Parameter(name="history", in="formData", type="string"),
     *     @SWG\Parameter(name="other_history", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="dental_health", in="formData", type="string", pattern="^(?:Good|Excellent|Fair|Poor)$"),
     *     @SWG\Parameter(name="removable", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="year_completed", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_problems", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain_describe", in="formData", type="string"),
     *     @SWG\Parameter(name="completed_future", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="clinch_grind", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytohead", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoneck", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoface", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoteeth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytomouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="drymouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="jawjointsurgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="no_allergens", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_medications", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_history", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="orthodontics", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction_text", in="formData", type="string"),
     *     @SWG\Parameter(name="removable_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dentures", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="dentures_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_cp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_cp_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_pain", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_pain_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="injury", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injury_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_prob", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_prob_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="clinch_grind_text", in="formData", type="string"),
     *     @SWG\Parameter(name="future_dental_det", in="formData", type="string"),
     *     @SWG\Parameter(name="drymouth_text", in="formData", type="string"),
     *     @SWG\Parameter(name="family_hd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_bp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_dia", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_sd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="allergenscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicationscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="historycheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Put(
     *     path="/health-histories/{health_histories}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="other_allergens", in="formData", type="string"),
     *     @SWG\Parameter(name="medications", in="formData", type="string"),
     *     @SWG\Parameter(name="other_medications", in="formData", type="string"),
     *     @SWG\Parameter(name="history", in="formData", type="string"),
     *     @SWG\Parameter(name="other_history", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="dental_health", in="formData", type="string", pattern="^(?:Good|Excellent|Fair|Poor)$"),
     *     @SWG\Parameter(name="removable", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="year_completed", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_problems", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain", in="formData", type="string"),
     *     @SWG\Parameter(name="dental_pain_describe", in="formData", type="string"),
     *     @SWG\Parameter(name="completed_future", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="clinch_grind", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytohead", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoneck", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoface", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytoteeth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injurytomouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="drymouth", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="jawjointsurgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="no_allergens", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_medications", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="no_history", in="formData", type="string", pattern="^[0-9]$"),
     *     @SWG\Parameter(name="orthodontics", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="wisdom_extraction_text", in="formData", type="string"),
     *     @SWG\Parameter(name="removable_text", in="formData", type="string"),
     *     @SWG\Parameter(name="dentures", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="dentures_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_cp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_cp_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_pain", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_pain_text", in="formData", type="string"),
     *     @SWG\Parameter(name="tmj_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="tmj_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="injury", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="injury_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_prob", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_prob_text", in="formData", type="string"),
     *     @SWG\Parameter(name="gum_surgery", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="gum_surgery_text", in="formData", type="string"),
     *     @SWG\Parameter(name="clinch_grind_text", in="formData", type="string"),
     *     @SWG\Parameter(name="future_dental_det", in="formData", type="string"),
     *     @SWG\Parameter(name="drymouth_text", in="formData", type="string"),
     *     @SWG\Parameter(name="family_hd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_bp", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_dia", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="family_sd", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="alcohol", in="formData", type="string"),
     *     @SWG\Parameter(name="sedative", in="formData", type="string"),
     *     @SWG\Parameter(name="caffeine", in="formData", type="string"),
     *     @SWG\Parameter(name="smoke", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="smoke_packs", in="formData", type="string"),
     *     @SWG\Parameter(name="tobacco", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="additional_paragraph", in="formData", type="string"),
     *     @SWG\Parameter(name="allergenscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="medicationscheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="historycheck", in="formData", type="boolean"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/health-histories/{health_histories}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Delete(
     *     path="/health-histories/{health_histories}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * Get health histories by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\HealthHistories $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(HealthHistories $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $healthHistories = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $healthHistories);
    }
}
