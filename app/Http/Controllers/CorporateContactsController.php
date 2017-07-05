<?php

namespace DentalSleepSolutions\Http\Controllers;

class CorporateContactsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/corporate-contacts",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/CorporateContact"))
     *                 )
     *             }
     *         )
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
     *     path="/corporate-contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/CorporateContact"))
     *             }
     *         )
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
     *     path="/corporate-contacts",
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="state", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="zip", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", required=true, pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", required=true),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="contacttypeid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/CorporateContact"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/corporate-contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string"),
     *     @SWG\Parameter(name="add1", in="formData", type="string"),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="contacttypeid", in="formData", type="integer"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
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
     *     path="/corporate-contacts/{id}",
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
