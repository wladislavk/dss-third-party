<?php

namespace DentalSleepSolutions\Http\Controllers;

class ScreenersController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/screeners",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Screener"))
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
     *     path="/screeners/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Screener"))
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
     *     path="/screeners",
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="first_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="last_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="epworth_reading", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_public", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_passenger", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lying", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_talking", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lunch", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_traffic", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="breathing", in="formData", type="integer"),
     *     @SWG\Parameter(name="driving", in="formData", type="integer"),
     *     @SWG\Parameter(name="gasping", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleepy", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore", in="formData", type="integer"),
     *     @SWG\Parameter(name="weight_gain", in="formData", type="integer"),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="jerk", in="formData", type="integer"),
     *     @SWG\Parameter(name="burning", in="formData", type="integer"),
     *     @SWG\Parameter(name="headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="falling_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="staying_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_hypertension", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heart_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_stroke", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_apnea", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_diabetes", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_lung_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_insomnia", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_depression", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_narcolepsy", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_medication", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_restless_leg", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heartburn", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_cpap", in="formData", type="integer"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", required=true, pattern="^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$"),
     *     @SWG\Parameter(name="contacted", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_metabolic_syndrome", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_obesity", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_afib", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Screener"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Post(
     *     path="/screeners",
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="first_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="last_name", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="epworth_reading", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_public", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_passenger", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lying", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_talking", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lunch", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_traffic", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="breathing", in="formData", type="integer"),
     *     @SWG\Parameter(name="driving", in="formData", type="integer"),
     *     @SWG\Parameter(name="gasping", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleepy", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore", in="formData", type="integer"),
     *     @SWG\Parameter(name="weight_gain", in="formData", type="integer"),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="jerk", in="formData", type="integer"),
     *     @SWG\Parameter(name="burning", in="formData", type="integer"),
     *     @SWG\Parameter(name="headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="falling_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="staying_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_hypertension", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heart_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_stroke", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_apnea", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_diabetes", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_lung_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_insomnia", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_depression", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_narcolepsy", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_medication", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_restless_leg", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heartburn", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_cpap", in="formData", type="integer"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", required=true, pattern="^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$"),
     *     @SWG\Parameter(name="contacted", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_metabolic_syndrome", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_obesity", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_afib", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Screener"))
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
     *     path="/screeners/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string"),
     *     @SWG\Parameter(name="last_name", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="epworth_reading", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_public", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_passenger", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lying", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_talking", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lunch", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_traffic", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="breathing", in="formData", type="integer"),
     *     @SWG\Parameter(name="driving", in="formData", type="integer"),
     *     @SWG\Parameter(name="gasping", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleepy", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore", in="formData", type="integer"),
     *     @SWG\Parameter(name="weight_gain", in="formData", type="integer"),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="jerk", in="formData", type="integer"),
     *     @SWG\Parameter(name="burning", in="formData", type="integer"),
     *     @SWG\Parameter(name="headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="falling_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="staying_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_hypertension", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heart_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_stroke", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_apnea", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_diabetes", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_lung_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_insomnia", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_depression", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_narcolepsy", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_medication", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_restless_leg", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heartburn", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_cpap", in="formData", type="integer"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$"),
     *     @SWG\Parameter(name="contacted", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_metabolic_syndrome", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_obesity", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_afib", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Put(
     *     path="/screeners/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="first_name", in="formData", type="string"),
     *     @SWG\Parameter(name="last_name", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="epworth_reading", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_public", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_passenger", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lying", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_talking", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_lunch", in="formData", type="integer"),
     *     @SWG\Parameter(name="epworth_traffic", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="breathing", in="formData", type="integer"),
     *     @SWG\Parameter(name="driving", in="formData", type="integer"),
     *     @SWG\Parameter(name="gasping", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleepy", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore", in="formData", type="integer"),
     *     @SWG\Parameter(name="weight_gain", in="formData", type="integer"),
     *     @SWG\Parameter(name="blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="jerk", in="formData", type="integer"),
     *     @SWG\Parameter(name="burning", in="formData", type="integer"),
     *     @SWG\Parameter(name="headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="falling_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="staying_asleep", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_blood_pressure", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_hypertension", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heart_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_stroke", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_apnea", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_diabetes", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_lung_disease", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_insomnia", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_depression", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_narcolepsy", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_medication", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_restless_leg", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_headaches", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_heartburn", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_cpap", in="formData", type="integer"),
     *     @SWG\Parameter(name="phone", in="formData", type="string", pattern="^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$"),
     *     @SWG\Parameter(name="contacted", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_metabolic_syndrome", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_obesity", in="formData", type="integer"),
     *     @SWG\Parameter(name="rx_afib", in="formData", type="integer"),
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
     *     path="/screeners/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    /**
     * @SWG\Delete(
     *     path="/screeners/{id}",
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
}
