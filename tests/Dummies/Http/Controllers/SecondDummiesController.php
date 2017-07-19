<?php

namespace Tests\Dummies\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\BaseRestController;
use Illuminate\Http\JsonResponse;

class SecondDummiesController extends BaseRestController
{
    public function getModelNamespace()
    {
        return 'Tests\\Dummies\\Eloquent';
    }

    /**
     * @SWG\Get(
     *     path="/admins",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/Admin")
     *                     )
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
     * @DSS\Manual
     * @SWG\Parameter(foo)
     * @SWG\Response(bar)
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function update($id)
    {
        return parent::update($id);
    }
}
